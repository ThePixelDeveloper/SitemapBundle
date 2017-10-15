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
     * @var ChunkedCollection
     */
    private $collectionSplitter;

    /**
     * SitemapPopulateEvent constructor.
     *
     * @param ChunkedUrlset $collectionSplitter
     */
    public function __construct(ChunkedUrlset $collectionSplitter)
    {
        $this->collectionSplitter = $collectionSplitter;
    }

    /**
     * @return ChunkedUrlset
     */
    public function getCollectionSplitter(): ChunkedUrlset
    {
        return $this->collectionSplitter;
    }
}

