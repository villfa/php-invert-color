<?php declare(strict_types=1);

namespace InvertColor;

use InvertColor\Exceptions\InvalidColorFormatException;

class Inverter
{

    /**
     * @param string $color
     * @return string
     */
    public function invert(string $color): string
    {
        list($r, $g, $b) = $this->hexToRGB($color);
	return sprintf('#%s%s%s', self::inv($r), self::inv($g), self::inv($b));
    }

    private static function inv(int $color): string
    {
        $inverted = dechex(255 - $color);
        return str_pad($inverted, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $hex
     * @return int[]
     * @throws InvalidColorFormatException
     */
    public function hexToRGB(string $hex): array
    {
        if (preg_match('/^#?(?=[0-9A-Fa-f]{3,6}$)(?:.{3}|.{6})$/', $hex)) {
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

}

