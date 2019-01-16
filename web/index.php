<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 13:31
 */

require __DIR__ . "/../vendor/autoload.php";
ini_set('memory_limit','-1');


$results = (new \App\AppQrReader("/Users/artem/PhpstormProjects/qr_decoder/web/good_data/"))->getResult();
var_dump($results);
