<?php

declare(strict_types=1);

namespace InvertColor\Color;

use function dechex;

/**
 * @internal
 */
final class RGBColor implements InternalColor
{
    /**
     * @var int[]
     */
    private $rgb;

    /**
     * @param int[] $rgb
     */
    public function __construct(array $rgb)
    {
        $this->rgb = $rgb;
    }

    public function getRGB(): array
    {
        return $this->rgb;
    }

    public function getHex(): string
    {
        $hex = '';
        foreach ($this->rgb as $channel) {
            if ($channel < 16) {
                $hex .= '0';
            }
            $hex .= dechex($channel);
        }

        return $hex;
    }

    public function invert(): InternalColor
    {
        return new self([
            255 - $this->rgb[0],
            255 - $this->rgb[1],
            255 - $this->rgb[2],
        ]);
    }
}
