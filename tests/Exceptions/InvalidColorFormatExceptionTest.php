<?php

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\InvalidColorFormatException;
use PHPUnit\Framework\TestCase;

class InvalidColorFormatExceptionTest extends TestCase
{
    public function testGetters()
    {
        $exception = new InvalidColorFormatException('foo/bar');
        $this->assertEquals('foo/bar', $exception->getValue());
        $this->assertEquals('Invalid color format: foo/bar', $exception->getMessage());
    }
}
