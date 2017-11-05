<?php declare(strict_types=1);

namespace Tests\Thepixeldeveloper\SitemapBundle\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;
use Thepixeldeveloper\SitemapBundle\Command\SitemapDumperCommand;
use Thepixeldeveloper\SitemapBundle\Event\SitemapPopulateEvent;
use Thepixeldeveloper\SitemapBundle\Interfaces\DumperInterface;

class SitemapDumperCommandTest extends TestCase
{
    public function testCommand()
    {
        $chunkedUrlset = new ChunkedUrlset();

        $dumper = $this->getMockBuilder(DumperInterface::class)->getMock();
        $dumper
            ->expects($this->once())
            ->method('writeChunkedUrlset')
            ->with($this->equalTo($chunkedUrlset))
        ;

        $eventDispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(SitemapPopulateEvent::NAME, $this->isInstanceOf(SitemapPopulateEvent::class))
        ;

        $input = $this->getMockBuilder(InputInterface::class)->getMock();
        $output = $this->getMockBuilder(OutputInterface::class)->getMock();

        $command = new SitemapDumperCommand($dumper, $eventDispatcher, $chunkedUrlset);
        $command->run($input, $output);
    }
}
