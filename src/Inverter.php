<?php declare(strict_types=1);

namespace InvertColor;

use InvertColor\Exceptions\InvalidColorFormatException;

define('THRESHOLD', sqrt(1.05 * 0.05) - 0.05);

class Inverter
{

    /**
     * @param string $color
     * @param bool   $bw
     * @return string
     */
    public function invert(string $color, bool $bw = false): string
    {
        if ($bw) {
            return $this->isBright($color) ? '#000000' : '#ffffff';
        }
        list($r, $g, $b) = $this->hexToRGB($color);
        return sprintf('#%s%s%s', self::inv($r), self::inv($g), self::inv($b));
    }

    private static function inv(int $color): string
    {
        $inverted = dechex(255 - $color);
        return str_pad($inverted, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $color
     * @return int[]
     * @throws InvalidColorFormatException
     */
    public function hexToRGB(string $color): array
    {
        if ($this->isValidColor($color)) {
            switch (\strlen($color)) {
            case 3:
                sscanf($color, '%1x%1x%1x', $r, $g, $b);
                return [$r * 17, $g * 17, $b * 17];
            case 4:
                sscanf($color, '#%1x%1x%1x', $r, $g, $b);
                return [$r * 17, $g * 17, $b * 17];
            case 6:
                return sscanf($color, '%2x%2x%2x');
            case 7:
                return sscanf($color, '#%2x%2x%2x');
            default:
                break;
            }
        }
        throw new InvalidColorFormatException('Invalid color format: ' . $color);
    }

    /**
     * @param string $color
     * @return bool
     */
    public function isValidColor(string $color): bool
    {
        return (bool) preg_match('/^#?(?:[0-9a-fA-F]{3}){1,2}$/', $color);
    }

    /**
     * @param string $color
     * @return float
     */
    public function getLuminance(string $color): float
    {
        $rgb = $this->hexToRGB($color);
        $levels = [];
        foreach ($rgb as $i => $channel) {
            $coef = $channel / 255;
            $levels[$i] = $coef <= 0.03928 ? $coef / 12.92 : (($coef + 0.055) / 1.055) ** 2.4;
        }
        return 0.2126 * $levels[0] + 0.7152 * $levels[1] + 0.0722 * $levels[2];
    }

    /**
     * @param string $color
     * @return bool
     */
    public function isBright(string $color): bool
    {
        $luminance = $this->getLuminance($color);
        return $luminance > THRESHOLD;
    }

    /**
     * @param string $color
     * @return bool
     */
    public function isDark(string $color): bool
    {
        return !$this->isBright($color);
    }
}
