<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class SitemapController extends Controller
{
    /**
     * @var string
     */
    private $directory;

    /**
     * SitemapController constructor.
     *
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return Response
     */
    public function sitemapAction(): Response
    {
        $response = new BinaryFileResponse(rtrim($this->directory, '/') . '/sitemap-0.xml');
        $response->headers->set('Content-Type', 'application/xml');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            'sitemap.xml'
        );

        return $response;
    }
}
