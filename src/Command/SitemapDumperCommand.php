<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thepixeldeveloper\Sitemap\Interfaces\CollectionSplitterInterface;
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
     * @var CollectionSplitterInterface
     */
    private $collectionSplitter;

    /**
     * SitemapDumperCommand constructor.
     *
     * @param DumperInterface             $dumper
     * @param EventDispatcherInterface    $eventDispatcher
     * @param CollectionSplitterInterface $collectionSplitter
     */
    public function __construct(
        DumperInterface $dumper,
        EventDispatcherInterface $eventDispatcher,
        CollectionSplitterInterface $collectionSplitter
    ) {
        $this->dumper = $dumper;
        $this->eventDispatcher = $eventDispatcher;
        $this->collectionSplitter = $collectionSplitter;

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
            new SitemapPopulateEvent($this->collectionSplitter)
        );

        $this->dumper->writeCollectionSplitter($this->collectionSplitter);
    }
}
