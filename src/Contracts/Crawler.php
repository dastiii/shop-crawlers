<?php

namespace dastiii\Crawlers\Contracts;

interface Crawler
{
    public function getClient();
    public function getStatusCode();
    public function getCurrentUrl();
    public function getInitialUrl();

    public function getProductName();
    public function getProductPrice();
    public function getProductNumber();
    public function getProductStock();
    public function getProductInStorePlacement();
    public function getProductDescription();
    public function getProductImageUrl();
}
