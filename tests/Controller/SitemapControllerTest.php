<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Controller;

use PHPUnit\Framework\TestCase;

class SitemapControllerTest extends TestCase
{
    public function testSitemapAction()
    {
        $controller = new SitemapController(__DIR__ . '/resources/sitemaps');
        $response = $controller->sitemapAction();

        $this->assertSame('application/xml', $response->headers->get('Content-Type'));
        $this->assertSame('inline; filename="sitemap.xml"', $response->headers->get('Content-Disposition'));
    }
}
