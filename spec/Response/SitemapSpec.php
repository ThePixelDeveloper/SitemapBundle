<?php

namespace spec\Thepixeldeveloper\SitemapBundle\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Thepixeldeveloper\Sitemap\Interfaces\DriverInterface;
use Thepixeldeveloper\Sitemap\Urlset;
use Thepixeldeveloper\SitemapBundle\Response\Sitemap;
use PhpSpec\ObjectBehavior;

class SitemapSpec extends ObjectBehavior
{
    function let(DriverInterface $driver)
    {
        $this->beConstructedWith($driver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Sitemap::class);
    }

    function it_should_generate_output(Urlset $urlset, DriverInterface $driver)
    {
        $urlset->accept($driver)->willReturn('content');

        $this->output($urlset)->shouldBe('content');
    }

    function it_should_modify_a_response(Urlset $urlset, DriverInterface $driver, Response $response, ResponseHeaderBag $responseHeaderBag)
    {
        $urlset->accept($driver)->willReturn('content');

        $responseHeaderBag->set('Content-Type', 'application/xml')->shouldBeCalled();

        $response->headers = $responseHeaderBag;
        $response->setContent('content')->shouldBeCalled();

        $this->withResponse($urlset, $response)->shouldBeAnInstanceOf(Response::class);
    }
}
