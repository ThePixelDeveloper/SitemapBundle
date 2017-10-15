<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;
use Thepixeldeveloper\SitemapBundle\Event\SitemapPopulateEvent;
use Thepixeldeveloper\SitemapBundle\Interfaces\DumperInterface;

class SitemapDumperCommand extends Command
{
    /**
     * @var DumperInterface
     */
    private $dumper;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ChunkedUrlset
     */
    private $chunkedUrlset;

    /**
     * SitemapDumperCommand constructor.
     *
     * @param DumperInterface          $dumper
     * @param EventDispatcherInterface $eventDispatcher
     * @param ChunkedUrlset            $chunkedUrlset
     */
    public function __construct(
        DumperInterface $dumper,
        EventDispatcherInterface $eventDispatcher,
        ChunkedUrlset $chunkedUrlset
    ) {
        $this->dumper = $dumper;
        $this->eventDispatcher = $eventDispatcher;
        $this->chunkedUrlset = $chunkedUrlset;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('thepixedeveloper:sitemap:dump')
            ->setDescription('Dumps out sitemaps to a directory to read by the Sitemap Controller.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventDispatcher->dispatch(
            SitemapPopulateEvent::NAME,
            new SitemapPopulateEvent($this->chunkedUrlset)
        );

        $this->dumper->writeChunkedUrlset($this->chunkedUrlset);
    }
}
