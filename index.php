<?php

require_once __DIR__ . '/Parser/RuwardParser.php';
require_once __DIR__ . '/Parser/RuwardSettings.php';
require_once __DIR__ . '/ParserWorker.php';

use Parser\RuwardParser;
use Parser\RuwardSettings;

$parser = new RuwardParser();
$settings = new RuwardSettings();

$parserWorker = new ParserWorker($parser, $settings);

$result = $parserWorker->work();

usort($result, function($a, $b) {
  return (
    explode('#', $b['id'])[1]
    -
    explode('#', $a['id'])[1]
  );
});

file_put_contents(__DIR__ . '/result.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
