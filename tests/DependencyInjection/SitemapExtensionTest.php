<?php declare(strict_types=1);

namespace Tests\Thepixeldeveloper\SitemapBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Thepixeldeveloper\SitemapBundle\DependencyInjection\SitemapExtension;

class SitemapExtensionTest extends TestCase
{
    public function testSitemapDirectoryPassed()
    {
        $containerBuilder = new ContainerBuilder();

        $expectedDirectory = 'hello';

        $extension = new SitemapExtension();
        $extension->load([
            'thepixeldeveloper_sitemap' => [
                'sitemap_directory' => $expectedDirectory,
            ],
        ], $containerBuilder);

        $dumperDirectory = $containerBuilder
            ->getDefinition('Thepixeldeveloper\SitemapBundle\Dumper\SitemapDumper')
            ->getArgument('$directory');

        $controllerDirectory = $containerBuilder
            ->getDefinition('Thepixeldeveloper\SitemapBundle\Controller\SitemapController')
            ->getArgument('$directory');

        $this->assertSame($expectedDirectory, $dumperDirectory);
        $this->assertSame($expectedDirectory, $controllerDirectory);
    }
}
