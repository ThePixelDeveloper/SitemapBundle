<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Dumper;

use Thepixeldeveloper\Sitemap\Interfaces\CollectionSplitterInterface;
use Thepixeldeveloper\Sitemap\Interfaces\DriverInterface;
use Symfony\Component\Filesystem\Filesystem;
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
     * SitemapDumper constructor.
     *
     * @param DriverInterface $driver
     * @param Filesystem      $filesystem
     * @param string          $directory
     */
    public function __construct(DriverInterface $driver, Filesystem $filesystem, string $directory)
    {
        $this->driver = $driver;
        $this->filesystem = $filesystem;
        $this->directory = rtrim($directory, '/');
    }

    public function writeCollectionSplitter(CollectionSplitterInterface $collectionSplitter)
    {
        foreach ($collectionSplitter->getCollections() as $i => $item) {
            $filename = sprintf('sitemap_%d.xml', $i);

            $this->filesystem->dumpFile($this->directory . '/' . $filename,
                $item->accept($this->driver)
            );
        }
    }
}
