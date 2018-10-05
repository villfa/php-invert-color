<?php declare(strict_types=1);

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\ColorException;
use InvertColor\Exceptions\InvalidRGBException;
use PHPUnit\Framework\TestCase;

class InvalidRGBExceptionTest extends TestCase
{
    public function testGetters(): void
    {
        $exception = new InvalidRGBException('wrong content', ['foo' => 'bar']);
        static::assertEquals(['foo' => 'bar'], $exception->getValue());
        static::assertEquals('Invalid RGB: wrong content', $exception->getMessage());
        static::assertInstanceOf(ColorException::class, $exception);
        static::assertInstanceOf(\UnexpectedValueException::class, $exception);
    }
}
