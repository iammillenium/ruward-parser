<?php

namespace Parser;

require_once __DIR__ . '/IParserSettings.php';
require_once __DIR__ . '/../HtmlLoader.php';

use DOMDocument;
use DOMXPath;
use HtmlLoader\HtmlLoader;
use Parser\IParserSettings;

class RuwardSettings implements IParserSettings
{
  private $baseUrl;
  private $prefix;
  private $startPoint;
  private $endPoint;

  public function __construct(string $baseUrl = 'https://ruward.ru/mutual/', string $prefix = '?page=', $startPoint = false, $endPoint = false)
  {
    $this->baseUrl = $baseUrl;
    $this->prefix = $prefix;

    if ($startPoint && $endPoint) {
      $this->startPoint = $startPoint;
      $this->endPoint = $endPoint;
    } else {
      $nav = $this->getNav();
      $this->startPoint = $nav['start'];
      $this->endPoint = $nav['end'];
    }
  }

  private function getNav()
  {
    $loader = new HtmlLoader($this->baseUrl);

    $html = $loader->loadHtml();

    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $xpath = new DOMXPath($dom);

    $pages = $xpath->query('//div[@class="mypaginator"]')[0]->nodeValue;

    $pages = explode('/', $pages);

    return [
      'start' => intval(array_shift($pages)),
      'end' => intval(array_pop($pages))
    ];
  }

  public function getBaseUrl(): string
  {
    return $this->baseUrl;
  }

  public function getPrefix(): string
  {
    return $this->prefix;
  }

  public function getStartPoint(): int
  {
    return $this->startPoint;
  }

  public function getEndPoint(): int
  {
    return $this->endPoint;
  }
}
