<?php

namespace RalfScraper;

use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDomInterface;

class Finder
{

    private string $baseUrl;
    private string $basePath;
    private string $baseExt;

    public function __construct()
    {
        $url = 'https://ralfcasino.com/forums-ffshrine/archive/f-72.html';

        [$this->basePath, $this->baseExt] = explode(".", substr($url, -9)); 
        $this->baseUrl = substr($url, 0, -9);
    }

    public function findOnPage(string $regex, int $page): ?array
    {
        $url = $this->getPageUrl($page);

        try {
             $results = $this->scrapePage($url, $regex); 
        } catch (\RuntimeException ) {
            return null;
        }
        return $results;
    }

    private function getPageUrl(int $page): string
    {
        return $this->baseUrl . $this->basePath . ($page > 1 ? "-p-$page" : "") . ".$this->baseExt";
    }

    private function scrapePage(string $url, string $regex): array
    {

        $html = HtmlDomParser::file_get_html($url);

        $root = $html->findOne('div[id="content"] > ol');
        $nodes = $root->findMulti('li > a');

        $results = [];

        foreach ($nodes as $node) {
            $title = $node->innerText();
            if (preg_match($regex, $title)) {
                $results[] = $this->createResult($node);
            }
        }

        return $results;
    }

    private function createResult(SimpleHtmlDomInterface $node): Result
    {
        $title = $node->innerText();
        $link = substr($node->getAttribute("href"), 2);
        return new Result($title, $this->baseUrl.$link);
    }

}
