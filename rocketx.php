<?php

use Rocketx\App\{
    DataProcessing, Make
};

require_once __DIR__ . '/bootstrap/autoload.php';

$obj = new DataProcessing();
$config = $obj->getConfig();

if (!empty($config)) {
    $make = new Make($config);
    var_dump($make->getConfig());
}