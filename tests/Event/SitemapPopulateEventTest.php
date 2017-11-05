<?php declare(strict_types=1);

namespace Tests\Thepixeldeveloper\SitemapBundle\Event;

use PHPUnit\Framework\TestCase;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;
use Thepixeldeveloper\SitemapBundle\Event\SitemapPopulateEvent;

class SitemapPopulateEventTest extends TestCase
{
    public function testEvent()
    {
        $urlset = new ChunkedUrlset();

        $event = new SitemapPopulateEvent($urlset);

        $this->assertSame($urlset, $event->getUrlset());
        $this->assertSame('theixeldeveloper_sitemap.populate', SitemapPopulateEvent::NAME);
    }
}
