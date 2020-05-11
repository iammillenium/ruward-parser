<?php

require_once __DIR__ . '/Parser/IParser.php';
require_once __DIR__ . '/Parser/IParserSettings.php';
require_once __DIR__ . '/HtmlLoader.php';

use HtmlLoader\HtmlLoader;
use Parser\IParser;
use Parser\IParserSettings;

class ParserWorker
{
  private $parser;
  private $settings;

  public function __construct(IParser  $parser, IParserSettings $settings)
  {
    $this->parser = $parser;
    $this->settings = $settings;
  }

  public function work()
  {
    $result = [];
    for ($i = $this->settings->getStartPoint(); $i <= $this->settings->getEndPoint(); $i++) {
      $url = $this->settings->getBaseUrl() . $this->settings->getPrefix() . $i;

      $loader = new HtmlLoader($url);
      $html = $loader->loadHtml();

      $result = array_merge($this->parser->parse($html), $result);
    }

    return $result;
  }
}
