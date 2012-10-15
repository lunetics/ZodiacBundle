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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Lunetics\ZodiacBundle\Templating\Helper\ZodiacHelper;

/**
 * PhpUnit Class for Zodiac Helper
 *
 * @author Matthias Breddin <mb@lunetics.com>
 *
 * @covers ZodiacHelper
 */
class ZodiacHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ZodiacHelper::render
     */
    public function testRenderZodiac()
    {
        $templating = $this->getTemplatingMock();
        $templating->expects($this->once())
                ->method('render')
                ->will($this->returnValue('LuneticsZodiacBundle:Zodiac:render_string.html.twig'));
        $helper = new ZodiacHelper($templating);
        $this->assertEquals('LuneticsZodiacBundle:Zodiac:render_string.html.twig', $helper->renderZodiac('06.03.1980'));
    }

    /**
     * @covers ZodiacHelper::render
     */
    public function testRenderZodiacImage()
    {
        $templating = $this->getTemplatingMock();
        $templating->expects($this->once())
                ->method('render')
                ->will($this->returnValue('LuneticsZodiacBundle:Zodiac:render_image.html.twig'));
        $helper = new ZodiacHelper($templating);
        $this->assertEquals('LuneticsZodiacBundle:Zodiac:render_image.html.twig', $helper->renderZodiac('06.03.1980', 'image'));
    }

    /**
     * @covers ZodiacHelper::render
     */
    public function testRenderZodiacInvalid()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $templating = $this->getTemplatingMock();
        $helper = new ZodiacHelper($templating);
        $helper->renderZodiac('06.03.1980', 'invalid');
    }

    /**
     * Returns a mock for Templating
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Templating
     */
    public function getTemplatingMock()
    {
        return $this->getMockBuilder('Symfony\Component\Templating\EngineInterface')->disableOriginalConstructor()->getMock();
    }
}
