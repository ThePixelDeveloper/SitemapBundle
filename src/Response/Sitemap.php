<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Response;

use Symfony\Component\HttpFoundation\Response;
use Thepixeldeveloper\Sitemap\Interfaces\DriverInterface;
use Thepixeldeveloper\Sitemap\Interfaces\VisitorInterface;
use Thepixeldeveloper\SitemapBundle\Interfaces\ResponseInterface;

class Sitemap implements ResponseInterface
{
    /**
     * @var DriverInterface
     */
    private $driver;

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function output(VisitorInterface $sitemap): string
    {
        return $sitemap->accept($this->driver);
    }

    public function outputResponse(VisitorInterface $sitemap, Response $response): Response
    {
        $content = $sitemap->accept($this->driver);

        $response->setContent($content);
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }
}
