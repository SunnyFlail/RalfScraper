<?php

require_once __DIR__."/../vendor/autoload.php";

define("DIR_RESULTS", __DIR__."/../results/");

if (isset($argv)) {
    $controller = new RalfScraper\CliController();
    array_shift($argv);
    $controller->run($argv);
}