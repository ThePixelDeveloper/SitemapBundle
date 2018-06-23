<?php declare(strict_types=1);

namespace Tests\Thepixeldeveloper\SitemapBundle\Controller;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Thepixeldeveloper\SitemapBundle\Controller\SitemapController;

class SitemapControllerTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $filesystem;

    /**
     * Virtual filesystem.
     */
    protected function setUp()
    {
        $this->filesystem = vfsStream::setup('sitemaps', null, [
            'sitemap.xml'  => 'content',
            'urlset-0.xml' => 'content',
        ]);
    }

    public function providerRequests(): \Generator
    {
        yield [
            new Request([], ['sitemap' => 'sitemap'] ,[], [], [], []),
            'application/xml',
            'inline; filename=sitemap.xml',
        ];

        yield [
            new Request([], ['sitemap' => 'urlset-0'] ,[], [], [], []),
            'application/xml',
            'inline; filename=urlset-0.xml',
        ];
    }

    /**
     * @dataProvider providerRequests
     *
     * @param Request $request
     * @param string  $contentType
     * @param string  $contentDisposition
     */
    public function testSitemapAction(Request $request, string $contentType, string $contentDisposition)
    {
        $controller = new SitemapController($this->filesystem->url());
        $response = $controller->sitemapAction($request);

        $this->assertSame($contentType, $response->headers->get('Content-Type'));
        $this->assertSame($contentDisposition, $response->headers->get('Content-Disposition'));
    }
}
