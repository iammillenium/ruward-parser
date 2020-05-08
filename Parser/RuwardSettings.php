<?php

namespace Parser;

require_once __DIR__ . '/IParserSettings.php';

use Parser\IParserSettings;

class RuwardSettings implements IParserSettings
{
  private $baseUrl;
  private $prefix;
  private $startPoint;
  private $endPoint;

  public function __construct(string $baseUrl = 'https://ruward.ru/mutual/', string $prefix = '?page=', int $startPoint = 1, int $endPoint = 7)
  {
    $this->baseUrl = $baseUrl;
    $this->prefix = $prefix;
    $this->startPoint = $startPoint;
    $this->endPoint = $endPoint;
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
