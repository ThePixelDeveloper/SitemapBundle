<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SitemapExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $dumper = $container->findDefinition('Thepixeldeveloper\SitemapBundle\Dumper\SitemapDumper');
        $dumper->setArgument('$directory', $config['sitemap_directory']);

        $controller = $container->findDefinition('Thepixeldeveloper\SitemapBundle\Controller\SitemapController');
        $controller->setArgument('$directory', $config['sitemap_directory']);
    }
}
