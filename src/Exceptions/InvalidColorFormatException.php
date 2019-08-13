<?php

declare(strict_types=1);

namespace InvertColor\Exceptions;

use UnexpectedValueException;

class InvalidColorFormatException extends UnexpectedValueException implements ColorException
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        parent::__construct('Invalid color format: ' . $value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
