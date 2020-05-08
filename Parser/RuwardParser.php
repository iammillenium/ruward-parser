<?php

namespace Parser;

use DOMDocument;
use DOMXPath;

require_once __DIR__ . '/RuwardParser.php';
require_once __DIR__ . '/IParser.php';

class RuwardParser implements IParser
{
  protected function getDescription($xpath, $node)
  {
    $result = '';

    $paragraphs = $xpath->query('.//div[@class="redorderleft"]/p', $node);

    foreach ($paragraphs as $p) {
      $result .= $p->nodeValue;
    }

    return $result;
  }

  protected function getNeed($xpath, $node)
  {
    $need = $xpath->query('.//div[@class="redorderleft"]/h4', $node)[0]->nodeValue;

    return explode(': ', $need)[1];
  }

  protected function getCompanyInfo($xpath, $node)
  {
    $a = $xpath->query('.//div[@class="newscontent"]/h3/a', $node);
    $paragraphs = $xpath->query('.//div[@class="redorderright"]/p', $node);

    $companyInfo = '';

    foreach ($paragraphs as $p) {
      $companyInfo .= $p->nodeValue;
    }

    return [
      'url' => $a[0]->getAttribute('href'),
      'name' => $a[0]->nodeValue,
      'description' => $companyInfo
    ];
  }

  protected function getContacts($xpath, $node)
  {
    $paragraphs = $xpath->query('.//div[@class="redcontact"]/p', $node);

    return [
      'fullName' => explode(' ', explode(': ', $paragraphs[0]->nodeValue)[1]),
      'email' => explode(': ', $paragraphs[1]->nodeValue)[1],
      'phone' => explode(': ', $paragraphs[2]->nodeValue)[1]
    ];
  }

  public function parse($html): array
  {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $xpath = new DOMXPath($dom);

    $newsItems = $xpath->query('//div[@class="newsitem"]');

    foreach ($newsItems as $news) {
      $date = $xpath->query('.//p[@class="date"]', $news)[0]->nodeValue;
      preg_match('/\#\d+/', $date, $matches);
      $id = array_shift($matches);
      $info['id'] = $id;
      $info['need'] = $this->getNeed($xpath, $news);
      $info['description'] = $this->getDescription($xpath, $news);
      $info['contacts'] = $this->getContacts($xpath, $news);
      $info['company'] = $this->getCompanyInfo($xpath, $news);

      $result[] = $info;
    }

    return $result;
  }
}
