<?php

use Rocketx\App\{
    ConcatConfig, Make
};

require_once __DIR__ . '/bootstrap/autoload.php';

$config = (new ConcatConfig())->getConfig();

if (!empty($config)) {
    $make = new Make($config);
    var_dump($make->getConfig());
}
