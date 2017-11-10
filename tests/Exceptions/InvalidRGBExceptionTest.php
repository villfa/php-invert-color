<?php

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\InvalidRGBException;
use PHPUnit\Framework\TestCase;

class InvalidRGBExceptionTest extends TestCase
{
    public function testGetters()
    {
        $exception = new InvalidRGBException('wrong content', ['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $exception->getValue());
        $this->assertEquals('Invalid RGB: wrong content', $exception->getMessage());
    }
}
