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
 */
class ZodiacHelperTest extends \PHPUnit_Framework_TestCase
{

    public function testRenderZodiac()
    {
        $templating = $this->getTemplatingMock();
        $templating->expects($this->once())
                ->method('render')
                ->will($this->returnValue('LuneticsZodiacBundle:Zodiac:render_string.html.twig'));
        $helper = new ZodiacHelper($templating);
        $this->assertEquals('LuneticsZodiacBundle:Zodiac:render_string.html.twig', $helper->renderZodiac('06.03.1980'));
    }

    public function testRenderZodiacImage()
    {
        $templating = $this->getTemplatingMock();
        $templating->expects($this->once())
                ->method('render')
                ->will($this->returnValue('LuneticsZodiacBundle:Zodiac:render_image.html.twig'));
        $helper = new ZodiacHelper($templating);
        $this->assertEquals('LuneticsZodiacBundle:Zodiac:render_image.html.twig', $helper->renderZodiac('06.03.1980', 'image'));
    }

    public function testRenderZodiacInvalid()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $templating = $this->getTemplatingMock();
        $helper = new ZodiacHelper($templating);
        $helper->renderZodiac('06.03.1980', 'invalid');
    }

    public function getTemplatingMock()
    {
        return $this->getMockBuilder('Symfony\Component\Templating\EngineInterface')->disableOriginalConstructor()->getMock();
    }
}
