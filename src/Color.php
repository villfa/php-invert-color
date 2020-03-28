<?php

declare(strict_types=1);

namespace InvertColor;

use InvertColor\Exceptions\InvalidColorFormatException;
use InvertColor\Exceptions\InvalidRGBException;

use function count;
use function dechex;
use function hexdec;
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
     * @var int[]
     */
    private $rgb;

    /**
     * @param int[] $rgb
     */
    private function __construct(array $rgb)
    {
        $this->rgb = $rgb;
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
        return new self(self::hexToRGB($hex));
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

        return new self($rgb);
    }

    /**
     * @return int[]
     */
    public function getRGB(): array
    {
        return $this->rgb;
    }

    /**
     * @return string
     */
    public function getHex(): string
    {
        return '#'.
            ($this->rgb[0] > 15 ? dechex($this->rgb[0]) : '0' . dechex($this->rgb[0])).
            ($this->rgb[1] > 15 ? dechex($this->rgb[1]) : '0' . dechex($this->rgb[1])).
            ($this->rgb[2] > 15 ? dechex($this->rgb[2]) : '0' . dechex($this->rgb[2]));
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

        return '#'.
            self::inv($this->rgb[0]).
            self::inv($this->rgb[1]).
            self::inv($this->rgb[2]);
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

        return [
            255 - $this->rgb[0],
            255 - $this->rgb[1],
            255 - $this->rgb[2],
        ];
    }

    /**
     * @param bool $bw
     *
     * @return self
     */
    public function invertAsObj(bool $bw = false): self
    {
        return new self($this->invertAsRGB($bw));
    }

    /**
     * @return float
     *
     * @see https://www.w3.org/TR/WCAG20/relative-luminance.xml
     */
    public function getLuminance(): float
    {
        $levels = [];
        foreach ($this->rgb as $i => $channel) {
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
     * @param string $hex
     *
     * @throws InvalidColorFormatException
     *
     * @return int[]
     */
    private static function hexToRGB(string $hex): array
    {
        $hexLength = strlen($hex);
        $regex = self::REGEX_BY_LENGTH[$hexLength] ?? '';
        $match = [];
        if ($regex === '' || preg_match($regex, $hex, $match) !== 1) {
            throw new InvalidColorFormatException($hex);
        }

        return $hexLength > 4 ? [
            (int) hexdec($match[1]),
            (int) hexdec($match[2]),
            (int) hexdec($match[3]),
        ] : [
            (int) hexdec($match[1].$match[1]),
            (int) hexdec($match[2].$match[2]),
            (int) hexdec($match[3].$match[3]),
        ];
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

    /**
     * @param int $channel
     *
     * @return string
     */
    private static function inv(int $channel): string
    {
        $inverted = dechex(255 - $channel);

        return $channel > 239 ? '0' . $inverted : $inverted;
    }
}
