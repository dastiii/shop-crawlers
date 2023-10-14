<?php

namespace Dastiii\Crawlers;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use Dastiii\Crawlers\Contracts\Crawler as CrawlerContract;

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
                ->filterXPath('//span[@data-ui-name="ads.price.strong"]')
                ->first()
                ->text();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductBasePrice() : ?string
    {
        try {
            return $this->crawler
                ->filter('.buybox div.optional-hidden.font-xs.text-right')
                ->first()
                ->text();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getProductContents(): ?string
    {
        $basePrice = $this->getProductBasePrice();
        $price = $this->getProductPrice();
        
        if ($basePrice === null || $price === null) return null;

        $parts = explode('/', $basePrice);

        if (count($parts) !== 2) return null;

        $basePrice = number_format(floatval(str_replace(',', '.', trim(str_replace('€', '', $parts[0])))), 2);
        $price = number_format(floatval(str_replace(',', '.', $price)), 2);
        $basePriceUnit = trim($parts[1]);
        $contents = number_format($price / $basePrice, 2);

        return $contents." ".$basePriceUnit;
    }

    public function getProductNumber() : ?string
    {
        try {
            return substr(
                $this->crawler
                    ->filter('section.overview__description span.article-number')
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
        // Does not work anymore.
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
//                ->filter('.overview__available .overview__available-list .text-bold')
                ->filter('.overview__available div.tw-font-bold')
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
                    ->filter('.overview__available ol')
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

    public function getDatasheets(): array
    {
        try {
            $datasheets = [];
            $datasheetSource = $this->crawler->filter('h4.first-sheet > a');
            $datasheetCount = $datasheetSource->count();

            for ($i = 0; $i < $datasheetCount; $i++) {
                $node = $datasheetSource->getNode($i);

                $datasheets[] = [
                    'name' => $node->textContent,
                    'url' => $node->getAttribute('href')
                ];
            }

            return $datasheets;
        } catch (\Exception $e) {
            return [];
        }
    }
}
