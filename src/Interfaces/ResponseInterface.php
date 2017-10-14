<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Interfaces;

use Symfony\Component\HttpFoundation\Response;
use Thepixeldeveloper\Sitemap\Interfaces\VisitorInterface;

interface ResponseInterface
{
    public function output(VisitorInterface $sitemap): string;

    public function outputResponse(VisitorInterface $sitemap, Response $response): Response;
}
