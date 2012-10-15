<?php
/**
 * This file is part of the LuneticsZodiacBundle
 *
 * (c) Matthias Breddin / Lunetics Networks
 *
 * @author Matthias Breddin <mb@lunetics.com>
 * @link(https://github.com/lunetics/LuneticsZodiacBundle)
 * @link(http://www.lunetics.com
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lunetics\ZodiacBundle\Tests\Entity;

use Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator;

/**
 * PhpUnit Class for Testing the Zodiac Calculator
 *
 * @author Matthias Breddin <mb@lunetics.com>
 *
 * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator
 */
class ZodiacCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getZodiac
     */
    public function testZodiacStringWithDifferentDates()
    {
        $zodiac = new ZodiacCalculator('2012-04-19');
        $this->assertEquals('aries', $zodiac->getZodiac());

        $zodiac = new ZodiacCalculator('21. may');
        $this->assertEquals('taurus', $zodiac->getZodiac());
    }

    /**
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getZodiac
     */
    public function testZodiacDateTimeObject()
    {
        $date = new \DateTime('23. November 1980');
        $zodiac = new ZodiacCalculator($date);
        $this->assertEquals('sagittarius', $zodiac->getZodiac());
    }

    /**
     * @dataProvider zodiacDates
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getZodiac
     */
    public function testZodiacString($date, $sign)
    {
        $zodiac = new ZodiacCalculator($date);
        $this->assertEquals($sign, $zodiac->getZodiac());
    }

    /**
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getZodiacSignUnicode
     */
    public function testZodiacSignUnicode()
    {
        $zodiac = new ZodiacCalculator('06.03.1980');
        $this->assertEquals('♓', $zodiac->getZodiacSignUnicode());
    }

    /**
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getZodiacSignHtml
     */
    public function testZodiacSignHtml()
    {
        $zodiac = new ZodiacCalculator('06.03.1980');
        $this->assertEquals('&#9811;', $zodiac->getZodiacSignHtml());
    }

    /**
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getZodiacTranslatable
     */
    public function testZodiacStringTranslatable()
    {
        $zodiac = new ZodiacCalculator('1.1.2011');
        $this->assertEquals('lunetics_zodiac.astronomical.' . $zodiac->getZodiac(), $zodiac->getZodiacTranslatable());

        $ns = 'custom';
        $zodiac = new ZodiacCalculator('1.1.2011', $ns);
        $this->assertEquals($ns . '.astronomical.' . $zodiac->getZodiac(), $zodiac->getZodiacTranslatable());
    }

    /**
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getChineseZodiac
     */
    public function testChineseZodiacString()
    {
        $zodiac = new ZodiacCalculator('1980');
        $this->assertEquals('monkey', $zodiac->getChineseZodiac());
    }

    /**
     * @covers Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator::getChineseZodiacTranslatable
     */
    public function testChineseZodiacStringTranslatable()
    {
        $zodiac = new ZodiacCalculator('1.1.2011');
        $this->assertEquals('lunetics_zodiac.chinese.' . $zodiac->getChineseZodiac(), $zodiac->getChineseZodiacTranslatable());

        $ns = 'custom';
        $zodiac = new ZodiacCalculator('1.1.2011', $ns);
        $this->assertEquals($ns . '.chinese.' . $zodiac->getChineseZodiac(), $zodiac->getChineseZodiacTranslatable());
    }

    /**
     * Dataprovider with dates and corresponding zodiac signs
     *
     * @return array
     */
    public function zodiacDates()
    {
        return array(
            array('1980-03-21', 'aries'),
            array('1980-03-22', 'aries'),
            array('1980-04-19', 'aries'),
            array('1980-04-20', 'aries'),
            array('1980-04-21', 'taurus'),
            array('1980-04-22', 'taurus'),
            array('1980-05-20', 'taurus'),
            array('1980-05-21', 'taurus'),
            array('1980-05-22', 'gemini'),
            array('1980-05-23', 'gemini'),
            array('1980-06-20', 'gemini'),
            array('1980-06-21', 'gemini'),
            array('1980-06-22', 'cancer'),
            array('1980-06-23', 'cancer'),
            array('1980-07-21', 'cancer'),
            array('1980-07-22', 'cancer'),
            array('1980-07-23', 'leo'),
            array('1980-07-24', 'leo'),
            array('1980-08-22', 'leo'),
            array('1980-08-23', 'leo'),
            array('1980-08-24', 'virgo'),
            array('1980-08-25', 'virgo'),
            array('1980-09-22', 'virgo'),
            array('1980-09-23', 'virgo'),
            array('1980-09-24', 'libra'),
            array('1980-09-25', 'libra'),
            array('1980-10-22', 'libra'),
            array('1980-10-23', 'libra'),
            array('1980-10-24', 'scorpio'),
            array('1980-10-25', 'scorpio'),
            array('1980-11-21', 'scorpio'),
            array('1980-11-22', 'scorpio'),
            array('1980-11-23', 'sagittarius'),
            array('1980-11-24', 'sagittarius'),
            array('1980-12-20', 'sagittarius'),
            array('1980-12-21', 'sagittarius'),
            array('1980-12-22', 'capricorn'),
            array('1980-12-23', 'capricorn'),
            array('1980-01-19', 'capricorn'),
            array('1980-01-20', 'capricorn'),
            array('1980-01-21', 'aquarius'),
            array('1980-01-22', 'aquarius'),
            array('1980-02-18', 'aquarius'),
            array('1980-02-19', 'aquarius'),
            array('1980-02-20', 'pisces'),
            array('1980-02-21', 'pisces'),
            array('1980-03-19', 'pisces'),
            array('1980-03-20', 'pisces'),
        );
    }
}
