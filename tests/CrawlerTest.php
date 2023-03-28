<?php
beforeEach(fn() => \Dastiii\Crawlers\ObiDeCrawler::setStoreNumber(278));

it('can get all of a 6615397 information', function () {
    $crawler = new \Dastiii\Crawlers\ObiDeCrawler('https://www.obi.de/search/6615397');

    expect($crawler->getProductName())->toBe('Sakret Tiefengrund 5 l');
    expect($crawler->getProductPrice())->toBe('47,99');
    expect($crawler->getProductBasePrice())->toBe('9,60 € / l');
    expect($crawler->getProductContents())->toBe('5.00 l');
    expect($crawler->getProductNumber())->toBe('6615397');
    expect($crawler->getProductInStorePlacement())->toBe('Putz, Mörtel, Zement, Gang 27');
    expect($crawler->getProductDescription())->toContain('Artikelbeschreibung');
    expect($crawler->getProductImageUrl())->toBe('//images.obi.de/product/DE/415x415/661539_1.jpg');
    expect($crawler->getDatasheets())->toHaveLength(1);
});

it('can get all of 6939854 information', function () {
    $crawler = new \Dastiii\Crawlers\ObiDeCrawler('https://www.obi.de/search/6939854');

    expect($crawler->getProductName())->toBe('Knauf Tiefengrund LF 5 l');
    expect($crawler->getProductPrice())->toBe('31,99');
    expect($crawler->getProductBasePrice())->toBe('6,40 € / l');
    expect($crawler->getProductContents())->toBe('5.00 l');
    expect($crawler->getProductNumber())->toBe('6939854');
    expect($crawler->getProductInStorePlacement())->toBe('Putz, Mörtel, Zement, Gang 27; Fliesenchemie & Werkzeuge, Gang 40');
    expect($crawler->getProductDescription())->toContain('Artikelbeschreibung');
    expect($crawler->getProductImageUrl())->toBe('//images.obi.de/product/DE/415x415/693985_2.jpg');
    expect($crawler->getDatasheets())->toHaveLength(1);
});

it('can get all of 4630323 information', function () {
    $crawler = new \Dastiii\Crawlers\ObiDeCrawler('https://www.obi.de/search/4630323');

    expect($crawler->getProductName())->toBe('Bodenfliese Feng Nero Feinsteinzeug 60 cm x 30 cm');
    expect($crawler->getProductPrice())->toBe('32,38');
    expect($crawler->getProductBasePrice())->toBe('19,99 € / m²');
    expect($crawler->getProductContents())->toBe('1.62 m²');
    expect($crawler->getProductNumber())->toBe('4630323');
    expect($crawler->getProductInStorePlacement())->toBe('Badfliesen, Gang 38');
    expect($crawler->getProductDescription())->toContain('Artikelbeschreibung');
    expect($crawler->getProductImageUrl())->toBe('//images.obi.de/product/DE/415x415/463032_4.jpg');
    expect($crawler->getDatasheets())->toHaveLength(0);
});
//
