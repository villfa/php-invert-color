<?php declare(strict_types=1);

namespace InvertColor;

use InvertColor\Exceptions\InvalidColorFormatException;

define('THRESHOLD', sqrt(1.05 * 0.05) - 0.05);

class Inverter
{
    /**
     * @var array
     */
    private $rgb;

    /**
     * @param string $color
     * @throws InvalidColorFormatException
     */
    public function __construct(string $color)
    {
        $this->rgb = $this->hexToRGB($color);
    }

    /**
     * @param string $color
     * @return int[]
     * @throws InvalidColorFormatException
     */
    private function hexToRGB(string $color): array
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
    private function isValidColor(string $color): bool
    {
        return (bool) preg_match('/^#?(?:[0-9a-fA-F]{3}){1,2}$/', $color);
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

    private static function inv(int $color): string
    {
        $inverted = dechex(255 - $color);
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
