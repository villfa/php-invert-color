<?php

declare(strict_types=1);

namespace InvertColor\Color;

/**
 * @internal
 */
interface InternalColor
{
    /**
     * @return int[]
     */
    public function getRGB(): array;
    public function getHex(): string;
    public function invert(): InternalColor;
}
