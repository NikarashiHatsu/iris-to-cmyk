<?php

namespace OzdemirBurak\Iris\Tests;

use OzdemirBurak\Iris\Color\Hex;
use OzdemirBurak\Iris\Color\Hsl;
use OzdemirBurak\Iris\Color\Hsla;
use OzdemirBurak\Iris\Color\Hsv;
use OzdemirBurak\Iris\Color\Rgb;
use OzdemirBurak\Iris\Color\Rgba;
use PHPUnit\Framework\TestCase;

class OperationsTest extends TestCase
{
    /**
     * @group operations-saturate
     */
    public function testSaturation()
    {
        $this->assertEquals(new Hex('#80ff00'), (new Hsl('90, 80%, 50%'))->saturate(20)->toHex());
        $this->assertEquals(new Hex('#80cc33'), (new Hsl('90, 80%, 50%'))->desaturate(20)->toHex());
        $this->assertEquals(new Hex('#80b34d'), (new Hex('#80cc33'))->desaturate(20));
        $this->assertEquals(new Hex('#808080'), (new Hex('#80cc33'))->grayscale());
    }

    /**
     * @group operations-lighten
     */
    public function testLightness()
    {
        $this->assertEquals(new Hex('#b3f075'), (new Hsl('90, 80%, 50%'))->lighten(20)->toHex());
        $this->assertEquals(new Hex('#4d8a0f'), (new Hsl('90, 80%, 50%'))->darken(20)->toHex());
        $this->assertEquals(new Hex('#4d7a1f'), (new Hex('#80cc33'))->darken(20));
        $this->assertEquals(new Hex('#b3ff66'), (new Hex('#80cc33'))->brighten(20));
    }

    /**
     * @group operations-spin
     */
    public function testSpin()
    {
        $this->assertEquals(new Hex('#f2a60d'), (new Hsl('10,90%,50'))->spin(30)->toHex());
        $this->assertEquals(new Hex('#f20d59'), (new Hsl('10,90%,50'))->spin(-30)->toHex());
    }

    /**
     * @group operations-mix
     */
    public function testMix()
    {
        $this->assertEquals(new Hex('#808080'), (new Hex('#000'))->mix(new Hex('#fff')));
        $this->assertEquals(new Hex('#ff8000'), (new Hex('#ff0000'))->mix(new Hex('#ffff00')));
    }

    /**
     * @group operations-mixInHsv
     */
    public function testMixInHsv()
    {
        $this->assertEquals(
            new Hsv('275,20,40'),
            (new Hsv('300,10,20'))->mixInHsv((new Hsv('200,50,100'))->toRgb(), 25)
        );

        $this->assertEquals(
            (new Hsv('270,30,55'))->toRgba(),
            (new Hsv('300,20,50'))->toRgba()->mixInHsv(new Hsv('240,40,60'))
        );

        $this->assertEquals(
            new Hsv('345,60,25'),
            (new Hsv('0,100,50'))->mixInHsv(new Hsv('330,20,0'))
        );

        $this->assertEquals(
            new Hsv('20,25,40'),
            (new Hsv('100,0,50'))->mixInHsv(new Hsv('300,50,30'))
        );
    }

    /**
     * @group operations-is-light
     */
    public function testIsLight()
    {
        $this->assertFalse((new Hex('#000000'))->isLight());
        $this->assertTrue((new Hex('#ffffff'))->isLight());
        $this->assertTrue((new Hex('#808080'))->isLight());
        $this->assertTrue((new Hex('#888888'))->isLight());
        $this->assertFalse((new Hex('#777777'))->isLight());
        $this->assertFalse((new Hex('#ff0000'))->isLight());
        $this->assertTrue((new Hex('#ffff00'))->isLight());
    }

    /**
     * @group operations-is-dark
     */
    public function testIsDark()
    {
        $this->assertTrue((new Hex('#000000'))->isDark());
        $this->assertFalse((new Hex('#ffffff'))->isDark());
    }

    /**
     * @group operations-tint
     */
    public function testTint()
    {
        $this->assertEquals(new Hex('#80bfff'), (new Hex('#007fff'))->tint(50));
        $this->assertEquals(new Hex('#80bfff'), (new Hex('#007fff'))->tint());
    }

    /**
     * @group operations-shade
     */
    public function testShade()
    {
        $this->assertEquals(new Hex('#004080'), (new Hex('#007fff'))->shade(50));
        $this->assertEquals(new Hex('#004080'), (new Hex('#007fff'))->shade());
    }

    /**
     * @group operations-fade
     */
    public function testFade()
    {
        $this->assertEquals(new Hsla('90,90,50,0.1'), (new Hsl('90,90,50'))->fade(10));
        $this->assertEquals(new Rgba('128,242,13,0.1'), (new Rgb('128,242,13'))->fade(10));
    }

    /**
     * @group operations-fadeIn
     */
    public function testFadeIn()
    {
        $this->assertEquals(new Hsla('90,90,50,0.4'), (new Hsla('90,90,50,0.3'))->fadeIn(10));
        $this->assertEquals(new Rgba('128,242,13,0.4'), (new Rgba('128,242,13,0.3'))->fadeIn(10));
    }

    /**
     * @group operations-fadeOut
     */
    public function testFadeOut()
    {
        $this->assertEquals(new Hsla('90,90,50,0.2'), (new Hsla('90,90,50,0.3'))->fadeOut(10));
        $this->assertEquals(new Rgba('128,242,13,0.2'), (new Rgba('128,242,13,0.3'))->fadeOut(10));
    }
}
