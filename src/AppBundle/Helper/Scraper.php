<?php

namespace AppBundle\Helper;

use Goutte\Client as GoutteClient;


class Scraper {

    private $client;

    public function __construct(GoutteClient $client) {

        $this->client = $client;
    }

    public function getJson($url) {

        $links = $this->getLinks($url);

        $products = [];
        $total = 0;
        foreach ($links as $link) {
            $product = $this->getProductDetails($link);
            $total += $product['unit_price'];
            $products[] = $product;
        }

        $data = [];
        $data['products'] = $products;
        $data['total'] = $total;

        return json_encode($data);
    }

    public function getLinks($url) {

        $crawler = $this->client->request('GET', $url);
        $css = '#productLister div.productInfo h3 a ';

        $links = array();
        $crawler->filter($css)->each(function ($node) use (&$links) {
            $href = $node->extract(array('href'));
            $href = $href[0];
            $links[] = $href;
        });

        return $links;
    }

    public function getProductDetails($url) {

        echo "\n Crawling " . $url;

        $crawler = $this->client->request('GET', $url);

        $response = $this->client->getResponse();
        $content = $response->getContent();

        $product['size'] = $this->formatBytes(strlen($content));

        try {
            //Title
            $css = '#content > div.section.productContent > div.mainProductInfoWrapper div.productTitleDescriptionContainer';
            $filter = $crawler->filter($css);
            $product['title'] = trim($filter->text());

            //Price
            $css = '#content > div.section.productContent p.pricePerUnit';
            $filter = $crawler->filter($css);
            $unitPrice = trim($filter->text());
            //Strip non-numeric
            $unitPrice = preg_replace("/[^0-9.]/", "", $unitPrice);
            $product['unit_price'] = $unitPrice;

            //Description
            try {
                $css = '#content > div.section.productContent htmlcontent p:nth-child(1)';
                $filter = $crawler->filter($css);
                $product['description'] = trim($filter->text());
            } catch (\Exception $e) {
                //@todo - handle
            }

            return $product;

        } catch (\Exception $e) {

            echo "\n\n!!! Problem crawling " . $url . "\n";
            echo $e->getTraceAsString();
        }

    }

    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'k', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)] . 'b';
    }
}
