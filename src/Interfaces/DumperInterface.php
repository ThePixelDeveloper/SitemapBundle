<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Interfaces;

use Thepixeldeveloper\Sitemap\ChunkedUrlset;

interface DumperInterface
{
    public function writeChunkedUrlset(ChunkedUrlset $chuckedCollection);
}
