#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 13:31
 */

require __DIR__ . "/../vendor/autoload.php";
//ini_set('memory_limit','-1');

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

