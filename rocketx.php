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
        echo '---TEST---' . PHP_EOL;
        var_dump($make->checkFileAndDir());
        var_dump($make->pathSiteDir);
        var_dump($make->nameConfigFile);
        echo '---TEST---' . PHP_EOL;
        if ($make->checkFileAndDir()) {
            echo "RUN!" . PHP_EOL;
            $make->makeSiteDir();
            $make->writeNginxConfigFile();
        }
    }
} catch (Exception $e) {
    fwrite(STDOUT, 'Error: ' .  $e->getMessage() . PHP_EOL);
}
