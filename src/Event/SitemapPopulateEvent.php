<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Thepixeldeveloper\Sitemap\ChunkedCollection;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;
use Thepixeldeveloper\Sitemap\Interfaces\CollectionSplitterInterface;

class SitemapPopulateEvent extends Event
{
    const NAME = 'theixeldeveloper_sitemap.populate';

    /**
     * @var ChunkedUrlset
     */
    private $urlset;

    /**
     * SitemapPopulateEvent constructor.
     *
     * @param ChunkedUrlset $urlset
     */
    public function __construct(ChunkedUrlset $urlset)
    {
        $this->urlset = $urlset;
    }

    /**
     * @return ChunkedUrlset
     */
    public function getUrlset(): ChunkedUrlset
    {
        return $this->urlset;
    }
}
