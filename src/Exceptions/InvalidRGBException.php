<?php

declare(strict_types=1);

namespace InvertColor\Exceptions;

class InvalidRGBException extends \UnexpectedValueException implements ColorException
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
