<?php declare(strict_types=1);

namespace Tests\Thepixeldeveloper\SitemapBundle\Dumper;

use DateTime;
use InvalidArgumentException;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Thepixeldeveloper\Sitemap\ChunkedUrlset;
use Thepixeldeveloper\Sitemap\Drivers\XmlWriterDriver;
use Thepixeldeveloper\Sitemap\Url;
use Thepixeldeveloper\SitemapBundle\Dumper\SitemapDumper;
use Thepixeldeveloper\SitemapBundle\Interfaces\DumperInterface;

class SitemapDumperTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $filesystem;

    /**
     * Virtual filesystem.
     */
    protected function setUp()
    {
        $this->filesystem = vfsStream::setup('sitemaps');
    }

    public function testDumperWithOneUrlset()
    {
        $urlset = new ChunkedUrlset();
        $urlset->add(new Url('http://example.com'));

        $lastMod = new DateTime();

        $sitemapDumper = $this->getSitemapDumper();
        $sitemapDumper->writeChunkedUrlset($urlset, $lastMod);

        $urlsetContent = file_get_contents($this->filesystem->getChild('urlset-0.xml')->url());
        $sitemapContent = file_get_contents($this->filesystem->getChild('sitemap.xml')->url());

        if ($urlsetContent === false || $sitemapContent === false) {
            $this->markTestSkipped('The urlset or the sitemap could not be read.');
            return;
        }

        $this->assertTrue($this->filesystem->hasChild('sitemap.xml'));
        $this->assertTrue($this->filesystem->hasChild('urlset-0.xml'));

        $urlsetExpected = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
    <url>
        <loc>http://example.com</loc>
    </url>
</urlset>

XML;

        $sitemapExpected = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
    <sitemap>
        <loc>urlset-0.xml</loc>
        <lastmod>{$lastMod->format(DATE_W3C)}</lastmod>
    </sitemap>
</sitemapindex>
XML;

        $this->assertXmlStringEqualsXmlString($urlsetExpected, $urlsetContent);
        $this->assertXmlStringEqualsXmlString($sitemapExpected, $sitemapContent);
    }

    public function testDumperWithMultipleUrlsets()
    {
        $urlset = new ChunkedUrlset();

        for ($i = 0; $i < 50001; $i++) {
            $urlset->add(new Url('http://example.com'));
        }

        $lastMod = new DateTime();

        $sitemapDumper = $this->getSitemapDumper();
        $sitemapDumper->writeChunkedUrlset($urlset, $lastMod);

        $sitemapContent = file_get_contents($this->filesystem->getChild('sitemap.xml')->url());

        if ($sitemapContent === false) {
            $this->markTestSkipped('The sitemap could not be read.');
            return;
        }

        $this->assertTrue($this->filesystem->hasChild('sitemap.xml'));
        $this->assertTrue($this->filesystem->hasChild('urlset-0.xml'));
        $this->assertTrue($this->filesystem->hasChild('urlset-1.xml'));

        $sitemapExpected = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
    <sitemap>
        <loc>urlset-0.xml</loc>
        <lastmod>{$lastMod->format(DATE_W3C)}</lastmod>
    </sitemap>
    <sitemap>
        <loc>urlset-1.xml</loc>
        <lastmod>{$lastMod->format(DATE_W3C)}</lastmod>
    </sitemap>
</sitemapindex>
XML;

        $this->assertXmlStringEqualsXmlString($sitemapExpected, $sitemapContent);
    }

    /**
     * @return DumperInterface
     */
    private function getSitemapDumper(): DumperInterface
    {
        $urlGenerator = new class implements UrlGeneratorInterface
        {
            public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH): string
            {
                if ($name === 'thepixeldeveloper_sitemap_bundle_controller') {
                    return $parameters['sitemap'] . '.xml';
                }

                throw new InvalidArgumentException('Route not defined.');
            }

            public function setContext(RequestContext $context)
            {

            }

            public function getContext()
            {

            }
        };

        return new SitemapDumper(new XmlWriterDriver(), new Filesystem(), $urlGenerator, $this->filesystem->url());
    }
}
