<?php declare(strict_types=1);

namespace InvertColor;

use InvertColor\Exceptions\InvalidColorFormatException;

// sqrt(1.05 * 0.05) - 0.05 = 0.17912878474779
\define('LUMINANCE_THRESHOLD', 0.17912878474779);

class Color
{
    private const REGEX_BY_LENGTH = [
        3 => '/^([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/',
        4 => '/^#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/',
        6 => '/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/',
        7 => '/^#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/',
    ];

    /**
     * @var array
     */
    private $rgb;

    /**
     * @param string $hex
     * @throws InvalidColorFormatException
     */
    public function __construct(string $hex)
    {
        $this->rgb = $this->hexToRGB($hex);
    }

    /**
     * @param string $hex
     * @return int[]
     * @throws InvalidColorFormatException
     */
    private function hexToRGB(string $hex): array
    {
        $hexLength = \strlen($hex);
        $isValid = ($regex = self::REGEX_BY_LENGTH[$hexLength] ?? null) && \preg_match($regex, $hex, $match);
        if (!$isValid) {
            throw new InvalidColorFormatException($hex);
        }
        return $hexLength > 4 ? [
            \hexdec($match[1]),
            \hexdec($match[2]),
            \hexdec($match[3]),
        ] : [
            \hexdec($match[1].$match[1]),
            \hexdec($match[2].$match[2]),
            \hexdec($match[3].$match[3]),
        ];
    }

    /**
     * @param bool $bw
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

    private static function inv(int $channel): string
    {
        $inverted = \dechex(255 - $channel);
        return \str_pad($inverted, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return float
     * @link https://www.w3.org/TR/WCAG20/relative-luminance.xml
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
        return $this->getLuminance() > LUMINANCE_THRESHOLD;
    }

    /**
     * @return bool
     */
    public function isDark(): bool
    {
        return !$this->isBright();
    }
}
