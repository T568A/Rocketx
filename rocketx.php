<?php

require_once __DIR__ . '/bootstrap/autoload.php';

$obj = new \Rocketx\App\DataProcessing();
$config = $obj->getConfig();

if (!empty($config)) {
    $make = new \Rocketx\App\Make($config);
    var_dump($make->getConfig());


}
