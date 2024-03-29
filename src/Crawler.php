<?php

namespace Dastiii\Crawlers;

use Goutte\Client;

abstract class Crawler
{
    /**
     * Goutte Client
     * @var Client
     */
    protected $client;

    /**
     * DOM Crawler
     * @var \Symfony\Component\DomCrawler\Crawler|null
     */
    protected $crawler;

    /**
     * Initial url
     * @var string
     */
    protected $initialUrl;

    /**
     * Constructor
     *
     * @param string $initialUrl Initial request url
     */
    public function __construct($initialUrl)
    {
        $this->initialUrl = $initialUrl;

        $this->crawler = $this->makeRequest();
    }

    /**
     * Returns the url for the request
     *
     * @return string
     */
    protected function getRequestUrl() : string
    {
        return $this->getInitialUrl();
    }

    /**
     * Makes the request and returns the crawler.
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function makeRequest(): \Symfony\Component\DomCrawler\Crawler
    {
        $this->client = new Client();
        $this->client->setServerParameter(
            'HTTP_USER_AGENT',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:97.0) Gecko/20100101 Firefox/97.0'
        );


        return $this->client->request('GET', $this->getRequestUrl());
    }

    /**
     * Returns the status code of the request.
     *
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        if ($this->client) {
            return $this->client->getInternalResponse()->getStatusCode();
        }

        return null;
    }

    /**
     * Returns the current url (after redirects)
     *
     * @return string|null
     */
    public function getCurrentUrl(): ?string
    {
        if ($this->client) {
            return $this->client->getHistory()->current()->getUri();
        }

        return null;
    }

    /**
     * Returns the initial request url.
     *
     * @return string
     */
    public function getInitialUrl(): string
    {
        return $this->initialUrl;
    }

    /**
     * Returns the Goutte client
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
