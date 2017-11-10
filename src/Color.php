<?php declare(strict_types=1);

namespace InvertColor;

use InvertColor\Exceptions\InvalidColorFormatException;

define('THRESHOLD', sqrt(1.05 * 0.05) - 0.05);

class Color
{
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
        if ($this->isValidColor($hex)) {
            switch (\strlen($hex)) {
            case 3:
                sscanf($hex, '%1x%1x%1x', $r, $g, $b);
                return [$r * 17, $g * 17, $b * 17];
            case 4:
                sscanf($hex, '#%1x%1x%1x', $r, $g, $b);
                return [$r * 17, $g * 17, $b * 17];
            case 6:
                return sscanf($hex, '%2x%2x%2x');
            case 7:
                return sscanf($hex, '#%2x%2x%2x');
            default:
                break;
            }
        }
        throw new InvalidColorFormatException('Invalid color format: ' . $hex);
    }

    /**
     * @param string $hex
     * @return bool
     */
    private function isValidColor(string $hex): bool
    {
        return (bool) preg_match('/^#?(?:[0-9a-fA-F]{3}){1,2}$/', $hex);
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
        list($r, $g, $b) = $this->rgb;
        return sprintf('#%s%s%s', self::inv($r), self::inv($g), self::inv($b));
    }

    private static function inv(int $channel): string
    {
        $inverted = dechex(255 - $channel);
        return str_pad($inverted, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return float
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
        return $this->getLuminance() > THRESHOLD;
    }

    /**
     * @return bool
     */
    public function isDark(): bool
    {
        return !$this->isBright();
    }
}
