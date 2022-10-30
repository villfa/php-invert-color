<?php

declare(strict_types=1);

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\ColorException;
use InvertColor\Exceptions\InvalidRGBException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class InvalidRGBExceptionTest extends TestCase
{
    public function testGetters(): void
    {
        $exception = new InvalidRGBException('wrong content', ['foo' => 'bar']);
        static::assertEquals(['foo' => 'bar'], $exception->getValue());
        static::assertEquals('Invalid RGB: wrong content', $exception->getMessage());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeCaughtAsColorException(): void
    {
        try {
            throw new InvalidRGBException('wrong content', ['foo' => 'bar']);
        } catch (ColorException $exception) {
            return;
        }
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeCaughtAsUnexpectedValueExpection(): void
    {
        try {
            throw new InvalidRGBException('wrong content', ['foo' => 'bar']);
        } catch (UnexpectedValueException $exception) {
            return;
        }
    }
}
