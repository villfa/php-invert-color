<?php

declare(strict_types=1);

namespace InvertColor\Exceptions;

use UnexpectedValueException;

class InvalidRGBException extends UnexpectedValueException implements ColorException
{
    /**
     * @var array<mixed>
     */
    private $value;

    /**
     * @param string $explanation
     * @param array<mixed> $value
     */
    public function __construct(string $explanation, array $value)
    {
        parent::__construct('Invalid RGB: ' . $explanation);
        $this->value = $value;
    }

    /**
     * @return array<mixed>
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
