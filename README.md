**Notice**: This repository is a mirror of what's hosted on GitLab ([thepixeldeveloper/sitemap-bundle](https://gitlab.com/thepixeldeveloper/sitemap-bundle/)).

# Thepixeldeveloper\SitemapBundle

[![pipeline status](https://gitlab.com/thepixeldeveloper/sitemap-bundle/badges/master/pipeline.svg)](https://gitlab.com/thepixeldeveloper/sitemap-bundle/commits/master)
[![License](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/license)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)
[![Latest Stable Version](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/v/stable)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)
[![Total Downloads](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/downloads)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)

Integrates [thepixeldeveloper/sitemap](https://gitlab.com/thepixeldeveloper/sitemap-bundle/) into Symfony.

* [Installation](#installation)
* [Basic Usage](#basic-usage)

## Installation

``` bash
composer require "thepixeldeveloper/sitemap-bundle"
```

## Basic Usage

``` php
<?php declare(strict_types=1);

namespace AppBundle\Controllers;

class DefaultController extends Controller
{
    public function defaultAction(Request $request)
    {
        // Lets create a single entry.
        $url = new Url('https://example.com');
        $url->setLastMod(new \DateTime());
        $url->priority('never');

        // Add it to the collection.
        $urlset = new Urlset();
        $urlset->add($url);

        // Modify a response object to have the correct headers and return it.
        return $this->get('thepixeldeveloper_sitemap')->withResponse($urlset, new Response());

        // or just return the output as a string.
        $content = $this->get('thepixeldeveloper_sitemap')->outout($urlset);
    }
}

```


