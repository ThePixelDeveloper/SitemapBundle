<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        /**
         * @var ArrayNodeDefinition $rootNode
         */
        $rootNode = $treeBuilder->root('thepixeldeveloper_sitemap');

        $rootNode
            ->children()
                ->scalarNode('directory')->cannotBeEmpty()
            ->end()
        ;

        return $treeBuilder;
    }
}
