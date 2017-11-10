<?php

namespace InvertColor\Exceptions;

class InvalidColorFormatException extends \Exception
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
