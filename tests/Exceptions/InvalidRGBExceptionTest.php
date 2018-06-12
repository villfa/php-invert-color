<?php declare(strict_types=1);

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\ColorException;
use InvertColor\Exceptions\InvalidRGBException;
use PHPUnit\Framework\TestCase;

class InvalidRGBExceptionTest extends TestCase
{
    public function testGetters()
    {
        $exception = new InvalidRGBException('wrong content', ['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $exception->getValue());
        $this->assertEquals('Invalid RGB: wrong content', $exception->getMessage());
        $this->assertInstanceOf(ColorException::class, $exception);
        $this->assertInstanceOf(\UnexpectedValueException::class, $exception);
    }
}
