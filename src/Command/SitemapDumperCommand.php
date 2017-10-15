<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thepixeldeveloper\SitemapBundle\Interfaces\DumperInterface;

class SitemapDumperCommand extends Command
{
    /**
     * @var DumperInterface
     */
    private $dumper;

    /**
     * SitemapDumperCommand constructor.
     *
     * @param DumperInterface $dumper
     */
    public function __construct(DumperInterface $dumper)
    {
        $this->dumper = $dumper;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('thepixedeveloper:sitemap:dump')
            ->setDescription('Dumps a sitemap (or sitemaps) to a directory')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
