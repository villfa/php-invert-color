<?php

declare(strict_types=1);

namespace InvertColor\Color;

use function dechex;
use function hexdec;
use function str_pad;
use function str_split;

use const STR_PAD_LEFT;

/**
 * @internal
 */
final class HexColor implements InternalColor
{
    /**
     * @var string
     */
    private $hex;

    public function __construct(string $hex)
    {
        $this->hex = $hex;
    }

    /**
     * @inheritDoc
     */
    public function getRGB(): array
    {
        $rgb = [];
        foreach (str_split($this->hex, 2) as $channel) {
            $rgb[] = (int) hexdec($channel);
        }

        return $rgb;
    }

    public function getHex(): string
    {
        return $this->hex;
    }

    public function invert(): InternalColor
    {
        $inverted = hexdec($this->hex) ^ 0xFFFFFF;
        return new self(
            $inverted < 1048576
                ? str_pad(dechex($inverted), 6, '0', STR_PAD_LEFT)
                : dechex($inverted)
        );
    }
}
