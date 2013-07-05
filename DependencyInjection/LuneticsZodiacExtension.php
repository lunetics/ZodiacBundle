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

namespace Lunetics\ZodiacBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * @author Matthias Breddin <mb@lunetics.com>
 */
class LuneticsZodiacExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
