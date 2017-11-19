<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class SitemapControllerTest extends TestCase
{
    public function testSitemapAction()
    {
        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects($this->once())->method('get')->with('sitemap')->willReturn('sitemap');

        $controller = new SitemapController(__DIR__ . '/resources/sitemaps');
        $response = $controller->sitemapAction($request);

        $this->assertSame('application/xml', $response->headers->get('Content-Type'));
        $this->assertSame('inline; filename="sitemap.xml"', $response->headers->get('Content-Disposition'));
    }

    public function testUrlsetSitemapAction()
    {
        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects($this->once())->method('get')->with('sitemap')->willReturn('urlset-0');

        $controller = new SitemapController(__DIR__ . '/resources/sitemaps');
        $response = $controller->sitemapAction($request);

        $this->assertSame('application/xml', $response->headers->get('Content-Type'));
        $this->assertSame('inline; filename="urlset-0.xml"', $response->headers->get('Content-Disposition'));
    }
}
