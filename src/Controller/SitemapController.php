<?php declare(strict_types=1);

namespace Thepixeldeveloper\SitemapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return BinaryFileResponse
     */
    public function sitemapAction(Request $request): BinaryFileResponse
    {
        $sitemap = $request->get('sitemap', 'sitemap');

        $sitemapFile = sprintf('%s/%s.xml', rtrim($this->directory, '/'), $sitemap);

        if (!file_exists($sitemapFile)) {
            throw new NotFoundHttpException(sprintf('The XML file "%s" was not found.', $sitemap));
        }

        $response = new BinaryFileResponse($sitemapFile);
        $response->headers->set('Content-Type', 'application/xml');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            sprintf('%s.xml', $sitemap)
        );

        return $response;
    }
}
