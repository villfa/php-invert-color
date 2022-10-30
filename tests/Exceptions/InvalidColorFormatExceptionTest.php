<?php

declare(strict_types=1);

namespace InvertColor\Tests\Exceptions;

use InvertColor\Exceptions\ColorException;
use InvertColor\Exceptions\InvalidColorFormatException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class InvalidColorFormatExceptionTest extends TestCase
{
    public function testGetters(): void
    {
        $exception = new InvalidColorFormatException('foo/bar');
        static::assertEquals('foo/bar', $exception->getValue());
        static::assertEquals('Invalid color format: foo/bar', $exception->getMessage());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeCaughtAsColorException(): void
    {
        try {
            throw new InvalidColorFormatException('foo/bar');
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
            throw new InvalidColorFormatException('foo/bar');
        } catch (UnexpectedValueException $exception) {
            return;
        }
    }
}
