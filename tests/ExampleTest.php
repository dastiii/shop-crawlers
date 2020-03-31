<?php

namespace Dastiii\Crawlers\Tests;

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
        $this->assertTrue(true);
    }
}
