**Notice**: This repository is a mirror of what's hosted on GitLab ([thepixeldeveloper/sitemap-bundle](https://gitlab.com/thepixeldeveloper/sitemap-bundle/)).

# Thepixeldeveloper\SitemapBundle

[![pipeline status](https://gitlab.com/thepixeldeveloper/sitemap-bundle/badges/master/pipeline.svg)](https://gitlab.com/thepixeldeveloper/sitemap-bundle/commits/master)
[![License](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/license)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)
[![Latest Stable Version](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/v/stable)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)
[![Total Downloads](https://poser.pugx.org/thepixeldeveloper/sitemap-bundle/downloads)](https://packagist.org/packages/thepixeldeveloper/sitemap-bundle)

A symfony bundle that integrates [thepixeldeveloper/sitemap](https://gitlab.com/thepixeldeveloper/sitemap-bundle/).

* [Installation](#installation)
* [Features](#features)
* [Usage](#usage)

## Installation

1. Require as a composer dependency:

    ``` bash
    composer require "thepixeldeveloper/sitemap-bundle"
    ```


2. Register the bundle:

    ``` php
    //app/AppKernel.php
    public function registerBundles()
    {
        $bundles = [
            new Thepixeldeveloper\SitemapBundle\SitemapBundle(),
        ];
    }
    ```

## Features

1. Handling of sitemap limits, ie file splitting.

## Usage

Read usage documentation starting from [Resources/docs/start.md](tree/master/src/Resources/docs/start.md)
