<?php

declare(strict_types=1);

namespace InvertColor;

use InvertColor\Color\HexColor;
use InvertColor\Color\InternalColor;
use InvertColor\Color\RGBColor;
use InvertColor\Exceptions\InvalidColorFormatException;
use InvertColor\Exceptions\InvalidRGBException;

use function count;
use function is_int;
use function preg_match;
use function strlen;

class Color
{
    /**
     * Threshold used to determinate if a color is bright or dark.
     *
     * The value comes from the following formula:
     * sqrt(1.05 * 0.05) - 0.05 = 0.17912878474779
     */
    public const LUMINANCE_THRESHOLD = 0.17912878474779;

    private const REGEX_BY_LENGTH = [
        3 => '/^([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/',
        4 => '/^#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/',
        6 => '/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/',
        7 => '/^#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/',
    ];

    /**
     * @var InternalColor
     */
    private $internalColor;

    /**
     * @param InternalColor $internalColor
     */
    private function __construct(InternalColor $internalColor)
    {
        $this->internalColor = $internalColor;
    }

    /**
     * @static
     *
     * @param string $hex
     *
     * @throws InvalidColorFormatException
     *
     * @return self
     */
    public static function fromHex(string $hex): self
    {
        $hexLength = strlen($hex);
        $regex = self::REGEX_BY_LENGTH[$hexLength] ?? '';
        $m = [];
        if ($regex === '' || preg_match($regex, $hex, $m) !== 1) {
            throw new InvalidColorFormatException($hex);
        }

        return new self(
            $hexLength > 4
            ? new HexColor($m[1] . $m[2] . $m[3])
            : new HexColor($m[1] . $m[1] . $m[2] . $m[2] . $m[3] . $m[3])
        );
    }

    /**
     * @static
     *
     * @param int[] $rgb
     *
     * @throws InvalidRGBException
     *
     * @return self
     */
    public static function fromRGB(array $rgb): self
    {
        self::checkRGB($rgb);

        return new self(new RGBColor($rgb));
    }

    /**
     * @return int[]
     */
    public function getRGB(): array
    {
        return $this->internalColor->getRGB();
    }

    /**
     * @return string
     */
    public function getHex(): string
    {
        return '#' . $this->internalColor->getHex();
    }

    /**
     * @param bool $bw
     *
     * @return string
     */
    public function invert(bool $bw = false): string
    {
        if ($bw) {
            return $this->isBright() ? '#000000' : '#ffffff';
        }

        return '#' . $this->internalColor->invert()->getHex();
    }

    /**
     * @param bool $bw
     *
     * @return int[]
     */
    public function invertAsRGB(bool $bw = false): array
    {
        if ($bw) {
            return $this->isBright() ? [0, 0, 0] : [255, 255, 255];
        }

        return $this->internalColor->invert()->getRGB();
    }

    /**
     * @param bool $bw
     *
     * @return self
     */
    public function invertAsObj(bool $bw = false): self
    {
        if ($bw) {
            return new self(new RGBColor($this->isBright() ? [0, 0, 0] : [255, 255, 255]));
        }

        return new self($this->internalColor->invert());
    }

    /**
     * @return float
     *
     * @see https://www.w3.org/TR/WCAG20/relative-luminance.xml
     */
    public function getLuminance(): float
    {
        $levels = [];
        foreach ($this->internalColor->getRGB() as $i => $channel) {
            $coef = $channel / 255;
            $levels[$i] = $coef <= 0.03928 ? $coef / 12.92 : (($coef + 0.055) / 1.055) ** 2.4;
        }

        return 0.2126 * $levels[0] + 0.7152 * $levels[1] + 0.0722 * $levels[2];
    }

    /**
     * @return bool
     */
    public function isBright(): bool
    {
        return $this->getLuminance() > self::LUMINANCE_THRESHOLD;
    }

    /**
     * @return bool
     */
    public function isDark(): bool
    {
        return $this->getLuminance() <= self::LUMINANCE_THRESHOLD;
    }

    /**
     * @static
     *
     * @param array<mixed> $rgb
     *
     * @throws InvalidRGBException
     */
    private static function checkRGB(array $rgb): void
    {
        if (3 !== count($rgb)) {
            throw new InvalidRGBException('must contain 3 values exactly', $rgb);
        }
        if (!isset($rgb[0], $rgb[1], $rgb[2])) {
            throw new InvalidRGBException('indexes must be integers and start at 0', $rgb);
        }
        if (!is_int($rgb[0]) || !is_int($rgb[1]) || !is_int($rgb[2])) {
            throw new InvalidRGBException('values must be integers', $rgb);
        }
        if ($rgb[0] < 0 || $rgb[1] < 0 || $rgb[2] < 0) {
            throw new InvalidRGBException('values must be greater or equal to 0', $rgb);
        }
        if ($rgb[0] > 255 || $rgb[1] > 255 || $rgb[2] > 255) {
            throw new InvalidRGBException('values must be lesser or equal to 255', $rgb);
        }
    }
}
