<?php

use Rocketx\App\{
    ConcatConfig, Make
};

require_once __DIR__ . '/bootstrap/autoload.php';

try {
    $config = (new ConcatConfig())->getConfig();
    if (!empty($config->script->help)) {
        ob_start();
        require __DIR__ . '/help.txt';
        fwrite(STDOUT, ob_get_clean());
    } else if (!empty($config->script->list)) {
        foreach (new \DirectoryIterator('templates') as $file) {
            if (!$file->isDot()) {
                fwrite(STDOUT, $file->getFilename());
            }
        }
    } else if (!empty($config)) {
        $make = new Make($config);
        $content = $make->getNginxConfig();
        if ($make->checkFileAndDir() && !empty($content)) {
            $make->makeSiteDir();
            $make->writeNginxConfigFile($content);
        }
    } else {
        throw new \Exception('invalid options');
    }
} catch (Exception $e) {
    fwrite(STDOUT, 'Error: ' .  $e->getMessage() . PHP_EOL);
}
