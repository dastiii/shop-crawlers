<?php

namespace Dastiii\Crawlers;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dastiii\Crawlers\Skeleton\SkeletonClass
 */
class CrawlersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'crawlers';
    }
}
