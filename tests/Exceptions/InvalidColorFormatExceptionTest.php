<?php declare(strict_types=1);

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\ColorException;
use InvertColor\Exceptions\InvalidColorFormatException;
use PHPUnit\Framework\TestCase;

class InvalidColorFormatExceptionTest extends TestCase
{
    public function testGetters()
    {
        $exception = new InvalidColorFormatException('foo/bar');
        $this->assertEquals('foo/bar', $exception->getValue());
        $this->assertEquals('Invalid color format: foo/bar', $exception->getMessage());
        $this->assertInstanceOf(ColorException::class, $exception);
        $this->assertInstanceOf(\UnexpectedValueException::class, $exception);
    }
}
