<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 13:31
 */

require __DIR__ . "/../vendor/autoload.php";
//ini_set('memory_limit','-1');

$fileHelper = new \App\Helper\FileHelper("/Users/artem/PhpstormProjects/qr_decoder/web/good_data/");
$results = (new \App\AppQrReader($fileHelper))->getResult();
var_dump($results);
