<?php

namespace Dastiii\Crawlers\Tests;

use Dastiii\Crawlers\ObiDeCrawler;
use Orchestra\Testbench\TestCase;
use Dastiii\Crawlers\CrawlersServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [CrawlersServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        ObiDeCrawler::setStoreNumber(278);
        $product =  (new ObiDeCrawler('https://www.obi.de/search/3201423'))
            ->getProductName();

//        dump($product);
    }
}
