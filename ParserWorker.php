<?php

require_once __DIR__ . '/Parser/IParser.php';
require_once __DIR__ . '/Parser/IParserSettings.php';

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

      $html = $this->loadHtml($url);

      $result = array_merge($this->parser->parse($html), $result);
    }

    return $result;
  }

  protected function loadHtml($url): string
  {
    $options = array(
      CURLOPT_POST => false,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
    );

    $curl = curl_init($url);

    curl_setopt_array($curl, $options);

    $result = curl_exec($curl);

    return $result;
  }
}
