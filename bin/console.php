#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use \DecoderQR\Helper\ConsoleFileHelper;
use \DecoderQR\DecoderQR;
use \DecoderQR\Helper\ConsoleHelper;

$basePath = __DIR__."/../";

//TODO add try-catch for case when --dir does not set
$consoleHelper = new ConsoleHelper();
$dataPath = $basePath.$consoleHelper->getPathOption();


$fileHelper = new ConsoleFileHelper($dataPath);
$results = (new DecoderQR($fileHelper))->getResults($consoleHelper->getCompressOption());
var_dump($results);
