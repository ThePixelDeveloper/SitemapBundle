<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Interfaces;

use Thepixeldeveloper\Sitemap\Interfaces\CollectionSplitterInterface;

interface DumperInterface
{
    public function writeCollectionSplitter(CollectionSplitterInterface $collectionSplitter);
}
