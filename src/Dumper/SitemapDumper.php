<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Dumper;

use Symfony\Component\Routing\RouterInterface;
use Thepixeldeveloper\Sitemap\ChunkedSitemapIndex;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;
use Thepixeldeveloper\Sitemap\Interfaces\DriverInterface;
use Symfony\Component\Filesystem\Filesystem;
use Thepixeldeveloper\Sitemap\Sitemap;
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
     * @var RouterInterface
     */
    private $router;

    /**
     * SitemapDumper constructor.
     *
     * @param DriverInterface $driver
     * @param Filesystem      $filesystem
     * @param RouterInterface $router
     * @param string          $directory
     */
    public function __construct(DriverInterface $driver, Filesystem $filesystem, RouterInterface $router, string $directory)
    {
        $this->driver = $driver;
        $this->filesystem = $filesystem;
        $this->router = $router;
        $this->directory = rtrim($directory, '/');
    }

    public function writeChunkedUrlset(ChunkedUrlset $chunkedUrlset)
    {
        $chunkedSitemapIndexes = new ChunkedSitemapIndex();

        foreach ($chunkedUrlset->getCollections() as $i => $item) {
            $filename = sprintf('urlsets-%d.xml', $i);

            $sitemap = new Sitemap(
                $this->router->generate('thepixeldeveloper_sitemap', [
                    'filename' => $filename,
                ])
            );
            $sitemap->setLastMod(new \DateTime());

            $chunkedSitemapIndexes->add($sitemap);

            $this->filesystem->dumpFile($this->directory . '/' . $filename,
                $item->accept($this->driver)
            );
        }

        foreach ($chunkedSitemapIndexes->getCollections() as $i => $item) {
            $filename = sprintf('sitemap-%d.xml', $i);

            $this->filesystem->dumpFile($this->directory . '/' . $filename,
                $item->accept($this->driver)
            );
        }
    }
}
