<?php

namespace Parser;

interface IParserSettings
{
  public function getBaseUrl(): string;
  public function getPrefix(): string;
  public function getStartPoint(): int;
  public function getEndPoint(): int;
}
