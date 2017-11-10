<?php

namespace InvertColor\Exceptions;

class InvalidRGBException extends \UnexpectedValueException
{
    /**
     * @var array
     */
    private $value;

    /**
     * @param array $value
     */
    public function __construct(string $explanation, array $value)
    {
        parent::__construct('Invalid RGB: ' . $explanation);
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
