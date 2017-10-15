<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Thepixeldeveloper\Sitemap\Interfaces\CollectionSplitterInterface;

class SitemapPopulateEvent extends Event
{
    const NAME = 'theixeldeveloper_sitemap.populate';

    /**
     * @var CollectionSplitterInterface
     */
    private $collectionSplitter;

    /**
     * SitemapPopulateEvent constructor.
     *
     * @param CollectionSplitterInterface $collectionSplitter
     */
    public function __construct(CollectionSplitterInterface $collectionSplitter)
    {
        $this->collectionSplitter = $collectionSplitter;
    }

    /**
     * @return CollectionSplitterInterface
     */
    public function getCollectionSplitter(): CollectionSplitterInterface
    {
        return $this->collectionSplitter;
    }
}

