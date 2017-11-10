<?php

namespace InvertColor\Tests;

use InvertColor\Exceptions\InvalidColorFormatException;
use InvertColor\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    private const BLACK = '#000000';
    private const WHITE = '#ffffff';

    /**
     * @dataProvider colorProvider
     */
    public function testInvertColor($hex, $expected)
    {
        $color = new Color($hex);
        $this->assertEquals($expected, $color->invert());
    }

    public function colorProvider()
    {
        return [
            ['#ffffff', '#000000'],
            ['#000000', '#ffffff'],
            ['ffffff', '#000000'],
            ['000000', '#ffffff'],
            ['#fff', '#000000'],
            ['#000', '#ffffff'],
            ['fff', '#000000'],
            ['000', '#ffffff'],
            ['#201395', '#dfec6a'],
            ['#840133', '#7bfecc'],
            ['#6ec6c8', '#913937'],
            ['#7fa1d3', '#805e2c'],
            ['#e0c04e', '#1f3fb1'],
            ['#3ad673', '#c5298c'],
            ['#edffe7', '#120018'],
            ['#a8f2f0', '#570d0f'],
            ['#da6aaa', '#259555'],
            ['#f9c6be', '#063941'],
            ['#2c2ea2', '#d3d15d'],
            ['#53456a', '#acba95'],
            ['#ab1b77', '#54e488'],
            ['#9288a4', '#6d775b'],
            ['#cf4a78', '#30b587'],
            ['#463069', '#b9cf96'],
            ['#ac6d63', '#53929c'],
            ['#be5a33', '#41a5cc'],
            ['#a07c96', '#5f8369'],
            ['#710cd1', '#8ef32e'],
            ['#676693', '#98996c'],
            ['#230be2', '#dcf41d'],
            ['#9481a4', '#6b7e5b'],
            ['#490cf8', '#b6f307'],
            ['#389847', '#c767b8'],
            ['#4898c2', '#b7673d'],
            ['#71d449', '#8e2bb6'],
            ['#61ad88', '#9e5277'],
            ['#bd3a5b', '#42c5a4'],
            ['#e32ac1', '#1cd53e'],
            ['#ac3ba9', '#53c456'],
            ['#c78ef0', '#38710f'],
            ['#48bdda', '#b74225'],
            ['#7855ae', '#87aa51'],
            ['#bf9845', '#4067ba'],
            ['#b2b766', '#4d4899'],
            ['#6ca3d9', '#935c26'],
            ['#b0af42', '#4f50bd'],
            ['#9fec76', '#601389'],
            ['#de79f1', '#21860e'],
            ['#5b7b0a', '#a484f5'],
            ['#27a5ec', '#d85a13'],
            ['#a3375e', '#5cc8a1'],
            ['#414176', '#bebe89'],
            ['#cde92f', '#3216d0'],
            ['#d13eb4', '#2ec14b'],
            ['#ee7d54', '#1182ab'],
            ['#35b9dc', '#ca4623'],
            ['#bf137b', '#40ec84'],
            ['#b7027c', '#48fd83'],
            ['#282b35', '#d7d4ca'],
            ['#951a9d', '#6ae562'],
            ['#566394', '#a99c6b'],
        ];
    }

    /**
     * @dataProvider invalidColorProvider
     */
    public function testExceptionWithInvalidFormat($hex)
    {
        $this->expectException(InvalidColorFormatException::class);
        new Color($hex);
    }

    public function invalidColorProvider()
    {
        return [
            ['#0000001'],
            ['#00000Z'],
            ['#00'],
            [''],
        ];
    }

    public function getBrightColors()
    {
        return [
            '#e71398',
            '#3ab3af',
            '#76ff98',
            '#bbb962',
            '#52838b',
            '#fff',
        ];
    }

    public function getDarkColors()
    {
        return [
            '#631746',
            '#655c42',
            '#166528',
            '#4c2946',
            '#002d26',
            '#000',
        ];
    }

    /**
     * @dataProvider blackOrWhiteProvider
     */
    public function testInvertColorToBlackOrWhite($hex, $expected)
    {
        $color = new Color($hex);
        $this->assertEquals($expected, $color->invert(true));
    }

    public function blackOrWhiteProvider()
    {
        return array_merge(
            array_map(function ($hex) {
                return [$hex, self::BLACK];
            }, $this->getBrightColors()),
            array_map(function ($hex) {
                return [$hex, self::WHITE];
            }, $this->getDarkColors())
        );
    }

    /**
     * @dataProvider isBrightProvider
     */
    public function testIsBrightOrDark($hex, $expected)
    {
        $color = new Color($hex);
        $this->assertEquals($expected, $color->isBright());
        $this->assertEquals(!$expected, $color->isDark());
    }

    public function isBrightProvider()
    {
        return array_merge(
            array_map(function ($hex) {
                return [$hex, true];
            }, $this->getBrightColors()),
            array_map(function ($hex) {
                return [$hex, false];
            }, $this->getDarkColors())
        );
    }
}