<?php

use Rocketx\App\{
    ConcatConfig, Make
};

require_once __DIR__ . '/bootstrap/autoload.php';

try {
    $config = (new ConcatConfig())->getConfig();

    if (!empty($config)) {
        $make = new Make($config);
        var_dump($make->getConfig());
    }
} catch (Exception $e) {
    echo 'Error: ' .  $e->getMessage() . PHP_EOL;
}
