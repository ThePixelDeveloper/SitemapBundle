<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Interfaces;

use DateTimeInterface;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;

interface DumperInterface
{
    public function writeChunkedUrlset(ChunkedUrlset $chuckedCollection, DateTimeInterface $lastMod = null);
}
