<?php

use PhpStructureGenerator\Generator\Parser;
use PhpStructureGenerator\Generator\Settings;
use Symfony\Component\Yaml\Yaml;

include __DIR__ . '/../vendor/autoload.php';

if(empty($argv[1])){
    echo 'You should tell what file I need to parse';
    die();
}

$yaml = Yaml::parseFile($argv[1]);


$parser = new Parser();
$parser->parse($yaml, new Settings());
