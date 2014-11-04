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

namespace Lunetics\ZodiacBundle\Twig\Extension;

use Lunetics\ZodiacBundle\Zodiac\ZodiacCalculator;
use Lunetics\ZodiacBundle\Templating\Helper\ZodiacHelper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * This class adds twig functionality for displaying a zodiac
 *
 * @author Matthias Breddin <mb@lunetics.com>
 */
class ZodiacExtension extends \Twig_Extension
{
    /**
     * ZodiacHelper
     *
     * @var ZodiacHelper
     */
    protected $helper;

    /**
     * Translator
     *
     * @var \Symfony\Component\Translation\Translator
     */
    protected $translator;

    /**
     * Default params for this extension
     *
     * @var array
     */
    protected $params;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->translator = $this->container->get('translator');
        $this->params = array('type' => null, 'raw' => false, 'translationkey' => false, 'format' => 'unicode');
    }

    /**
     * Injects the ZodiacHelper
     *
     * @param ZodiacHelper $helper
     */
    public function setHelper(ZodiacHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            'zodiac' => new \Twig_Filter_Method($this, 'getZodiacString', array('is_safe' => array('html'))),
            'zodiac_sign' => new \Twig_Filter_Method($this, 'getZodiacSign', array('is_safe' => array('html')))
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'zodiac' => new \Twig_Function_Method($this, 'renderZodiacString', array('pre_escape' => 'html', 'is_safe' => array('html')
            )),
        );
    }

    /**
     * Returns the string for a zodiac
     *
     * @param mixed $date   Date or \DateTime Object
     * @param array $params Parameters for the zodiac twig filter
     *                      Default is array('type' => null, 'raw' => false,'translationkey' => false)
     *
     * @return mixed
     * @throws \Twig_Error_Runtime
     */
    public function getZodiacString($date, $params = array())
    {
        $params = array_merge($this->params, $params);
        $zodiac = new ZodiacCalculator($date);
        if (method_exists($zodiac, 'get' . ucfirst($params['type']) . 'Zodiac')) {
            if ($params['raw'] === true) {
                return $zodiac->{'get' . ucfirst($params['type']) . 'Zodiac'}();
            } elseif ($params['translationkey'] === true) {
                return $zodiac->{'get' . ucfirst($params['type']) . 'ZodiacTranslatable'}();
            } elseif (method_exists($zodiac, 'get' . ucfirst($params['type']) . 'ZodiacTranslatable')) {
                return $this->translator->trans($zodiac->{'get' . ucfirst($params['type']) . 'ZodiacTranslatable'}(), array(), 'LuneticsZodiacBundle');
            }
        }

        throw new \Twig_Error_Runtime(sprintf('"%s" is an invalid zodiac type.', $params['type']));
    }

    /**
     * Returns the Zodiac Sign
     *
     * @param mixed $date   Date or \DateTime Object
     * @param array $params Parameters for the zodiac_sign twig filter.
     *                      Default is: array('format'=> 'unicode', 'type = null);
     *
     * @return mixed
     * @throws \Twig_Error_Runtime
     */
    public function getZodiacSign($date, $params = array())
    {
        $params = array_merge($this->params, $params);
        $format = ucfirst($params['format']);
        $zodiac = new ZodiacCalculator($date);
        if (method_exists($zodiac, 'get' . ucfirst($params['type']) . 'ZodiacSign' . $format)) {
            return $zodiac->{'get' . ucfirst($params['type']) . 'ZodiacSign' . $format}();
        }
        throw new \Twig_Error_Runtime(sprintf('Format "%s" is an invalid zodiac sign format or not yet implemented.', $format));
    }

    /**
     * Renders the string for a zodiac
     *
     * @param mixed $date Date or \DateTime Object
     *
     * @return string
     */
    public function renderZodiacString($date)
    {
        if (!$this->helper instanceof ZodiacHelper) {
            $this->helper = $this->container->get('lunetics_zodiac.zodiac_helper');
        }

        return $this->helper->renderZodiac($date, 'string');
    }

    /**
     * Returns the image for a zodiac
     *
     * @param string|\DateTime $date
     *
     * @return string
     */
    public function renderZodiacImage($date)
    {
        if (!$this->helper instanceof ZodiacHelper) {
            $this->helper = $this->container->get('lunetics_zodiac.zodiac_helper');
        }

        return $this->helper->renderZodiac($date, 'image');
    }


    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'zodiac_extension';
    }
}

