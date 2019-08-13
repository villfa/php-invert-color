<?php

declare(strict_types=1);

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\ColorException;
use InvertColor\Exceptions\InvalidColorFormatException;
use PHPUnit\Framework\TestCase;

class InvalidColorFormatExceptionTest extends TestCase
{
    public function testGetters(): void
    {
        $exception = new InvalidColorFormatException('foo/bar');
        static::assertEquals('foo/bar', $exception->getValue());
        static::assertEquals('Invalid color format: foo/bar', $exception->getMessage());
        static::assertInstanceOf(ColorException::class, $exception);
        static::assertInstanceOf(\UnexpectedValueException::class, $exception);
    }
}
