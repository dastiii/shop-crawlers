<?php

namespace dastiii\Crawlers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use dastiii\Crawlers\Contracts\Crawler as CrawlerContract;

class ObiDeCrawler extends Crawler implements CrawlerContract
{
    /**
     * Store number
     * @var int
     */
    protected static $storeNumber;

    /**
     * Sets the store number
     *
     * @param int $number
     */
    public static function setStoreNumber($number)
    {
        self::$storeNumber = $number;
    }

    /**
     * Returns the request Url
     *
     * @return string
     */
    public function getRequestUrl() : string
    {
        return 'https://www.obi.de/store/change?storeID='
            .self::$storeNumber
            .'&redirectUrl='
            .urlencode($this->initialUrl);
    }

    /**
     * Returns the products name
     *
     * @return string|null
     */
    public function getProductName() : ?string
    {
        try {
            return $this->crawler
                ->filterXPath('//h1[@data-ui-name="ads.overview-description.product-name.h1"]')
                ->first()
                ->text();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductPrice() : ?string
    {
        try {
            return $this->crawler
                ->filterXPath('//strong[@data-ui-name="ads.price.strong"]')
                ->first()
                ->text();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductNumber() : ?string
    {
        try {
            return substr(
                $this->crawler
                    ->filterXPath('//p[@data-ui-name="ads.description-text.article-number.p"]')
                    ->first()
                    ->text(),
                8,
                7
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductStock() : ?string
    {
        try {
            return trim(
                $this->crawler
                    ->filterXPath('//p[@data-ui-name="instore.adp.availability_message"]')
                    ->first()
                    ->text()
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductInStorePlacement() : ?string
    {
        try {
            return $this->crawler
                ->filter('.overview__available p.marg_t5.green')
                ->first()
                ->text();
        } catch (\Exception $e) {
            return $this->getMultpileProductInStorePlacements();
        }
    }

    protected function getMultpileProductInStorePlacements() : ?string
    {
        try {
            return implode(
                '; ',
                $this->crawler
                    ->filter('.overview__available .overview__available-list')
                    ->children()
                    ->each(function (DomCrawler $node, $i) {
                        return $node->text();
                    })
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductDescription() : ?string
    {
        try {
            return $this->crawler
                ->filter('div.description-text')
                ->first()
                ->html();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductImageUrl() : ?string
    {
        try {
            return $this->crawler
                ->filter('.pinch-zoom-container > .ads-slider__image')
                ->first()
                ->attr('src');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getStore() : string
    {
        try {
            return $this->crawler
                ->filterXPath('//a[@data-target="#My-Market"]')
                ->first()
                ->text();
        } catch (\Exception $e) {
            return '<unknown>';
        }
    }
}