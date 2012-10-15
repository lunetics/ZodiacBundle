<?php
/**
 * This file is part of the LuneticsZodiacBundle
 *
 * (c) Matthias Breddin / Lunetics Networks
 *
 * @author Matthias Breddin <mb@lunetics.com>
 * @link(https://github.com/lunetics/ZodiacBundle)
 * @link(http://www.lunetics.com)
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Lunetics\ZodiacBundle\Tests\Entity;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;

use Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension;

/**
 * PhpUnit Class for Testing the Zodiac Extension
 *
 * @author Matthias Breddin <mb@lunetics.com>
 *
 * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension
 */
class ZodiacExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ZodiacExtension */
    private $twigExtension;

    /** @var \Twig_Environment */
    private $twig;

    /**
     * Setup
     */
    public function setUp()
    {
        $locale = 'en';

        $translator = new Translator($locale);
        $translator->addLoader('yaml', new YamlFileLoader());

        $ressource = __DIR__ . '/../../../Resources/translations/LuneticsZodiacBundle.en.yml';
        $translator->addResource('yaml', $ressource, $locale, 'LuneticsZodiacBundle');

        $zodiacExtension = new ZodiacExtension($this->getContainerMock());
        $zodiacExtension->setTranslator($translator);
        $this->twigExtension = $zodiacExtension;

        $loader = new \Twig_Loader_String();
        $this->twig = new \Twig_Environment($loader, array(
            'debug' => true,
            'cache' => false,
            'autoescape' => false,
        ));

        $this->twig->addExtension($this->twigExtension);
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacString
     */
    public function testFilterMethodZodiacString()
    {
        $this->assertSame('Capricorn', $this->twig->render("{{ date|zodiac }}", array('date' => new \DateTime('01.01.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacString
     */
    public function testFilterMethodZodiacStringParamsTranslationkey()
    {
        $this->assertEquals('lunetics_zodiac.astronomical.capricorn', $this->twig->render("{{ date|zodiac({'translationkey':true}) }}", array('date' => new \DateTime('01.01.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacString
     */
    public function testFilterMethodZodiacStringWithType()
    {
        $this->assertEquals('Monkey', $this->twig->render("{{ date|zodiac({'type':'chinese'}) }}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacString
     */
    public function testFilterMethodZodiacStringParamsTypeAndTranslationkey()
    {
        $this->assertEquals('lunetics_zodiac.chinese.monkey', $this->twig->render("{{ date|zodiac({'type':'chinese','translationkey':true}) }}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacString
     */
    public function testFilterMethodZodiacStringInvalidType()
    {
        $this->setExpectedException('\Twig_Error_Runtime');
        $this->twig->render("{{ date|zodiac({'type':'foo'}) }}", array('date' => new \DateTime('06.03.1980')));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacString
     */
    public function testFilterMethodZodiacRawString()
    {
        $this->assertEquals('pisces', $this->twig->render("{{ date|zodiac({'raw':true}) }}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacString
     */
    public function testFilterMethodZodiacRawStringWithType()
    {
        $this->assertEquals('monkey', $this->twig->render("{{ date|zodiac({'type':'chinese', 'raw': true}) }}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacSign
     */
    public function testFilterMethodZodiacSign()
    {
        $this->assertEquals('♓', $this->twig->render("{{ date|zodiac_sign}}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacSign
     */
    public function testFilterMethodZodiacSignWithType()
    {
        $this->assertEquals('猴', $this->twig->render("{{ date|zodiac_sign({'type':'chinese'}) }}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacSign
     */
    public function testFilterMethodZodiacSignWithFormat()
    {
        $this->assertEquals('&#9811;', $this->twig->render("{{ date|zodiac_sign({'format':'html'}) }}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacSign
     */
    public function testFilterMethodZodiacSignWithTypeAndFormat()
    {
        $this->assertEquals('&#29492;', $this->twig->render("{{ date|zodiac_sign({'type':'chinese', 'format':'html'}) }}", array('date' => new \DateTime('06.03.1980'))));
    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacSign
     */
    public function testFilterMethodZodiacSignWithInvalidType()
    {
        $this->setExpectedException('\Twig_Error_Runtime');
        $this->twig->render("{{ date|zodiac_sign({'type':'foo','format':'html'}) }}", array('date' => new \DateTime('06.03.1980')));

    }

    /**
     * @covers Lunetics\ZodiacBundle\Twig\Extension\ZodiacExtension::getZodiacSign
     */
    public function testFilterMethodZodiacSignWithInvalidFormat()
    {
        $this->setExpectedException('\Twig_Error_Runtime');
        $this->twig->render("{{ date|zodiac_sign({'format':'foo'}) }}", array('date' => new \DateTime('06.03.1980')));
    }

    /**
     * Returns a ContainerInterface Mock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|ContainerInterface
     */
    public function getContainerMock()
    {
        return $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')->disableOriginalConstructor()->getMock();
    }
}
