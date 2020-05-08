<?php

namespace Parser;

interface IParser
{
  public function parse(string $html): array;
}
