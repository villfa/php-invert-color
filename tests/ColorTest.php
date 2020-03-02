<?php

declare(strict_types=1);

namespace InvertColor\Tests;

use InvertColor\Color;
use InvertColor\Exceptions\InvalidColorFormatException;
use InvertColor\Exceptions\InvalidRGBException;
use PHPUnit\Framework\TestCase;

use const INF;

class ColorTest extends TestCase
{
    private const BLACK = '#000000';
    private const WHITE = '#ffffff';

    /**
     * @dataProvider colorProvider
     * @testdox testInvertColor: $hex
     *
     * @param string $hex
     * @param string $expected
     */
    public function testInvertColor(string $hex, string $expected): void
    {
        $color = Color::fromHex($hex);
        static::assertEquals($expected, $color->invert());
    }

    /**
     * @dataProvider colorProvider
     * @testdox testInvertColorAsRGB: $hex
     *
     * @param string $hex
     * @param string $expected
     */
    public function testInvertColorAsRGB(string $hex, string $expected): void
    {
        $color = Color::fromHex($hex);
        $invertedColor = $color->invertAsRGB();
        static::assertEquals($expected, Color::fromRGB($invertedColor)->getHex());
    }

    /**
     * @dataProvider colorProvider
     * @testdox testInvertColorAsObj: $hex
     *
     * @param string $hex
     * @param string $expected
     */
    public function testInvertColorAsObj(string $hex, string $expected): void
    {
        $color = Color::fromHex($hex);
        static::assertEquals($expected, $color->invertAsObj()->getHex());
    }

    /**
     * @return iterable<array<string>>
     */
    public function colorProvider(): iterable
    {
        yield ['#ffffff', '#000000'];
        yield ['#000000', '#ffffff'];
        yield ['ffffff', '#000000'];
        yield ['000000', '#ffffff'];
        yield ['#fff', '#000000'];
        yield ['#000', '#ffffff'];
        yield ['fff', '#000000'];
        yield ['000', '#ffffff'];
        yield ['#201395', '#dfec6a'];
        yield ['#840133', '#7bfecc'];
        yield ['#6ec6c8', '#913937'];
        yield ['#7fa1d3', '#805e2c'];
        yield ['#e0c04e', '#1f3fb1'];
        yield ['#3ad673', '#c5298c'];
        yield ['#edffe7', '#120018'];
        yield ['#a8f2f0', '#570d0f'];
        yield ['#da6aaa', '#259555'];
        yield ['#f9c6be', '#063941'];
        yield ['#2c2ea2', '#d3d15d'];
        yield ['#53456a', '#acba95'];
        yield ['#ab1b77', '#54e488'];
        yield ['#9288a4', '#6d775b'];
        yield ['#cf4a78', '#30b587'];
        yield ['#463069', '#b9cf96'];
        yield ['#ac6d63', '#53929c'];
        yield ['#be5a33', '#41a5cc'];
        yield ['#a07c96', '#5f8369'];
        yield ['#710cd1', '#8ef32e'];
        yield ['#676693', '#98996c'];
        yield ['#230be2', '#dcf41d'];
        yield ['#9481a4', '#6b7e5b'];
        yield ['#490cf8', '#b6f307'];
        yield ['#389847', '#c767b8'];
        yield ['#4898c2', '#b7673d'];
        yield ['#71d449', '#8e2bb6'];
        yield ['#61ad88', '#9e5277'];
        yield ['#bd3a5b', '#42c5a4'];
        yield ['#e32ac1', '#1cd53e'];
        yield ['#ac3ba9', '#53c456'];
        yield ['#c78ef0', '#38710f'];
        yield ['#48bdda', '#b74225'];
        yield ['#7855ae', '#87aa51'];
        yield ['#bf9845', '#4067ba'];
        yield ['#b2b766', '#4d4899'];
        yield ['#6ca3d9', '#935c26'];
        yield ['#b0af42', '#4f50bd'];
        yield ['#9fec76', '#601389'];
        yield ['#de79f1', '#21860e'];
        yield ['#5b7b0a', '#a484f5'];
        yield ['#27a5ec', '#d85a13'];
        yield ['#a3375e', '#5cc8a1'];
        yield ['#414176', '#bebe89'];
        yield ['#cde92f', '#3216d0'];
        yield ['#d13eb4', '#2ec14b'];
        yield ['#ee7d54', '#1182ab'];
        yield ['#35b9dc', '#ca4623'];
        yield ['#bf137b', '#40ec84'];
        yield ['#b7027c', '#48fd83'];
        yield ['#282b35', '#d7d4ca'];
        yield ['#951a9d', '#6ae562'];
        yield ['#566394', '#a99c6b'];
    }

    /**
     * @dataProvider invalidColorProvider
     * @testdox testExceptionWithInvalidFormat: $hex
     *
     * @param string $hex
     */
    public function testExceptionWithInvalidFormat(string $hex): void
    {
        $this->expectException(InvalidColorFormatException::class);
        Color::fromHex($hex);
    }

    /**
     * @return iterable<array<string>>
     */
    public function invalidColorProvider(): iterable
    {
        yield ['#0000001'];
        yield ['#00000Z'];
        yield ['#00'];
        yield [''];
    }

    /**
     * @dataProvider validRGBProvider
     * @testdox testGetRGB: [$r, $g, $b]
     *
     * @param int $r
     * @param int $g
     * @param int $b
     */
    public function testGetRGB(int $r, int $g, int $b): void
    {
        $rgb = [$r, $g, $b];
        $color = Color::fromRGB($rgb);
        static::assertEquals($rgb, $color->getRGB());
    }

    /**
     * @return iterable<array<int>>
     */
    public function validRGBProvider(): iterable
    {
        yield [0, 0, 0];
        yield [255, 255, 255];
        yield [0, 255, 0];
        yield [42, 111, 33];
    }

    /**
     * @dataProvider invalidRGBProvider
     * @testdox testExceptionWithInvalidRGB: $explanation ($_testdoxMessage)
     *
     * @param array<mixed> $rgb
     * @param string $explanation
     * @param string $_testdoxMessage
     */
    public function testExceptionWithInvalidRGB(array $rgb, string $explanation, string $_testdoxMessage): void
    {
        $expectedException = new InvalidRGBException($explanation, $rgb);
        $this->expectExceptionObject($expectedException);
        Color::fromRGB($rgb);
    }

    /**
     * @return iterable<array<mixed>>
     */
    public function invalidRGBProvider(): iterable
    {
        $explanation = 'must contain 3 values exactly';
        yield [[], $explanation, 'empty array'];
        yield [[0], $explanation, '1 value'];
        yield [[0, 0], $explanation, '2 values'];
        yield [[0, 0, 0, 0], $explanation, '4 values'];
        $explanation = 'indexes must be integers and start at 0';
        yield [[null, 0, 0], $explanation, 'R is NULL'];
        yield [[1 => 0, 0, 0], $explanation, 'index starts at 1'];
        yield [['a' => 0, 'b' => 0, 'c' => 0], $explanation, 'indexes are strings'];
        $explanation = 'values must be integers';
        yield [['0', 0, 0], $explanation, 'R is string'];
        yield [[0, '0', 0], $explanation, 'G is string'];
        yield [[0, 0, '0'], $explanation, 'B is string'];
        yield [[0.0, 0, 0], $explanation, 'R is float'];
        yield [[INF, 0, 0], $explanation, 'R is INF'];
        $explanation = 'values must be greater or equal to 0';
        yield [[-1, 0, 0], $explanation, 'R = -1'];
        yield [[0, -1, 0], $explanation, 'G = -1'];
        yield [[0, 0, -1], $explanation, 'B = -1 '];
        yield [[-1, -1, -1], $explanation, 'R = -1, G = -1, B = -1'];
        $explanation = 'values must be lesser or equal to 255';
        yield [[256, 0, 0], $explanation, 'R = 256'];
        yield [[0, 256, 0], $explanation, 'G = 256'];
        yield [[0, 0, 256], $explanation, 'B = 256'];
        yield [[256, 256, 256], $explanation, 'R = 256, G = 256, B = 256'];
    }

    /**
     * @dataProvider blackOrWhiteProvider
     * @testdox testInvertColorToBlackOrWhite: $hex
     *
     * @param string $hex
     * @param string $expected
     */
    public function testInvertColorToBlackOrWhite(string $hex, string $expected): void
    {
        $color = Color::fromHex($hex);
        static::assertEquals($expected, $color->invert(true));
    }

    /**
     * @return iterable<array<mixed>>
     */
    public function blackOrWhiteProvider(): iterable
    {
        foreach (self::getBrightColors() as $hex) {
            yield [$hex, self::BLACK];
        }
        foreach (self::getDarkColors() as $hex) {
            yield [$hex, self::WHITE];
        }
    }

    /**
     * @dataProvider blackOrWhiteAsRGBProvider
     * @testdox testInvertColorToBlackOrWhiteAsRGB: $hex
     *
     * @param string $hex
     * @param array<int> $expected
     */
    public function testInvertColorToBlackOrWhiteAsRGB(string $hex, array $expected): void
    {
        $color = Color::fromHex($hex);
        static::assertEquals($expected, $color->invertAsRGB(true));
    }

    /**
     * @return iterable<array<mixed>>
     */
    public function blackOrWhiteAsRGBProvider(): iterable
    {
        foreach (self::getBrightColors() as $hex) {
            yield [$hex, [0, 0, 0]];
        }
        foreach (self::getDarkColors() as $hex) {
            yield [$hex, [255, 255, 255]];
        }
    }

    /**
     * @dataProvider isBrightProvider
     * @testdox testIsBrightOrDark: $hex
     *
     * @param string $hex
     * @param bool $expected
     */
    public function testIsBrightOrDark(string $hex, bool $expected): void
    {
        $color = Color::fromHex($hex);
        static::assertEquals($expected, $color->isBright());
        static::assertEquals(!$expected, $color->isDark());
    }

    /**
     * @return iterable<array<mixed>>
     */
    public function isBrightProvider(): iterable
    {
        foreach (self::getBrightColors() as $hex) {
            yield [$hex, true];
        }
        foreach (self::getDarkColors() as $hex) {
            yield [$hex, false];
        }
    }

    /**
     * @return iterable<string>
     */
    private static function getBrightColors(): iterable
    {
        yield '#e71398';
        yield '#3ab3af';
        yield '#76ff98';
        yield '#bbb962';
        yield '#52838b';
        yield '#fff';
    }

    /**
     * @return iterable<string>
     */
    private static function getDarkColors(): iterable
    {
        yield '#631746';
        yield '#655c42';
        yield '#166528';
        yield '#4c2946';
        yield '#002d26';
        yield '#000';
    }
}
