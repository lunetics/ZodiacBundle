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

namespace Lunetics\ZodiacBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\EngineInterface;
use Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator;

/**
 * Helper for the Twig extension
 *
 * @author Matthias Breddin <mb@lunetics.com>
 */
class ZodiacHelper extends Helper
{
    protected $templating;

    protected $templates = array(
        'string' => 'LuneticsZodiacBundle:Zodiac:render_string.html.twig',
        'image' => 'LuneticsZodiacBundle:Zodiac:render_image.html.twig'
    );

    /**
     * Constructor
     *
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * Render Method
     *
     * @param string|\DateTime $date     A Date string or \DateTime Object
     * @param string           $template Template to render
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function renderZodiac($date, $template = 'string')
    {
        $zodiac = new ZodiacCalculator($date);
        $viewParams['zodiac'] = array(
            'translatable' => $zodiac->getZodiacTranslatable(),
            'raw' => $zodiac->getZodiac(),
            'object' => $zodiac
        );
        if (!array_key_exists($template, $this->templates)) {
            throw new \InvalidArgumentException(sprintf('No template for templatekey "%s" defined', $template));
        }

        return $this->templating->render($this->templates[$template], $viewParams);
    }

    /**
     * Returns the name of the Helper
     *
     * @return string The name of the helper
     */
    public function getName()
    {
        return 'zodiac_helper';
    }
}
