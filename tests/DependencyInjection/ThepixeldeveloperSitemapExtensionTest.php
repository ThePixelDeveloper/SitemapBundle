<?php declare(strict_types=1);

namespace Tests\Thepixeldeveloper\SitemapBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Thepixeldeveloper\SitemapBundle\DependencyInjection\ThepixeldeveloperSitemapExtension;

class ThepixeldeveloperSitemapExtensionTest extends TestCase
{
    public function testSitemapDirectoryPassed()
    {
        $containerBuilder = new ContainerBuilder();

        $expectedDirectory = 'hello';

        $extension = new ThepixeldeveloperSitemapExtension();
        $extension->load([
            'thepixeldeveloper_sitemap' => [
                'directory' => $expectedDirectory,
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
