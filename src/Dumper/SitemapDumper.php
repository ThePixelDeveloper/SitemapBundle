<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Dumper;

use DateTime;
use DateTimeInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Thepixeldeveloper\Sitemap\ChunkedSitemapIndex;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;
use Thepixeldeveloper\Sitemap\Interfaces\DriverInterface;
use Symfony\Component\Filesystem\Filesystem;
use Thepixeldeveloper\Sitemap\Sitemap;
use Thepixeldeveloper\Sitemap\SitemapIndex;
use Thepixeldeveloper\Sitemap\Urlset;
use Thepixeldeveloper\SitemapBundle\Interfaces\DumperInterface;

class SitemapDumper implements DumperInterface
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $directory;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * SitemapDumper constructor.
     *
     * @param DriverInterface $driver
     * @param Filesystem      $filesystem
     * @param UrlGeneratorInterface $urlGenerator
     * @param string          $directory
     */
    public function __construct(DriverInterface $driver, Filesystem $filesystem, UrlGeneratorInterface $urlGenerator, string $directory)
    {
        $this->driver = $driver;
        $this->filesystem = $filesystem;
        $this->urlGenerator = $urlGenerator;
        $this->directory = rtrim($directory, '/');
    }

    public function writeChunkedUrlset(ChunkedUrlset $chunkedUrlset, DateTimeInterface $lastMod = null)
    {
        $lastMod = $lastMod ?? new DateTime();
        
        $sitemapIndex = new SitemapIndex();

        foreach ($chunkedUrlset->getCollections() as $i => $item) {
            $sitemap = new Sitemap(
                $this->urlGenerator->generate('thepixeldeveloper_sitemap_bundle_controller', [
                    'sitemap' => sprintf('urlset-%d', $i),
                ])
            );
            $sitemap->setLastMod($lastMod);

            $sitemapIndex->add($sitemap);

            $item->accept($this->driver);

            $this->filesystem->dumpFile(sprintf('%s/urlset-%d.xml', $this->directory, $i),
                $this->driver->output()
            );
        }

        $sitemapIndex->accept($this->driver);

        $this->filesystem->dumpFile(sprintf('%s/sitemap.xml', $this->directory),
            $this->driver->output()
        );
    }
}
