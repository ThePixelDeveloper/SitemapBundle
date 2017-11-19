# Thepixeldeveloper\SitemapBundle

[![pipeline status](https://www.devkit.net/thepixeldeveloper/sitemap-bundle/badges/master/pipeline.svg)](https://www.devkit.net/thepixeldeveloper/sitemap-bundle/commits/master)
[![coverage report](https://www.devkit.net/thepixeldeveloper/sitemap-bundle/badges/master/coverage.svg)](https://www.devkit.net/thepixeldeveloper/sitemap-bundle/commits/master)
[![License](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/license)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)
[![Latest Stable Version](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/v/stable)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)
[![Total Downloads](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/downloads)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)

A symfony bundle that integrates [thepixeldeveloper/sitemap](https://gitlab.com/thepixeldeveloper/sitemap).

* [Installation](#installation)
* [Usage](#usage)

## Installation

1. Require as a composer dependency:

    ``` bash
    composer require "thepixeldeveloper/sitemap-bundle"
    ```

2. Register the bundle:

    ``` php
    # app/AppKernel.php
    public function registerBundles()
    {
        $bundles = [
            new Thepixeldeveloper\SitemapBundle\ThepixeldeveloperSitemapBundle(),
        ];
    }
    ```

3. Import routing

    ``` yaml
    # app/config/routing.yml
    thepixeldeveloper_sitemap_bundle:
        resource: "@ThepixeldeveloperSitemapBundle/Resources/config/routing.yml"
        prefix:   /
    ```

4. Define where the XML files will be dumped.

    ``` yaml
    thepixeldeveloper_sitemap:
        directory: '%kernel.project_dir%/var/sitemaps'
    ```

## Usage

1. [Create an event listener](http://symfony.com/doc/current/event_dispatcher.html#creating-an-event-listener) for `theixeldeveloper_sitemap.populate`. Add Urls to the Urlset collection.

2. Sitemaps are generated as follows:

    ``` bash
    ./bin/console thepixedeveloper:sitemap:dump
    ```
    
3. Your sitemap will be accessible at: https://domain.tld/sitemap.xml
