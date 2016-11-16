<?php

use Rocketx\App\{Config, Make, PrintCli};

require_once __DIR__ . '/bootstrap/autoload.php';

try {
    $config = (new Config())->getConfig();
    if (!empty($config->script->help)) {
        PrintCli::getHelp();
    } else if (!empty($config->script->list)) {
        PrintCli::getTemplateList($config->script->templatesDir);
    } else if (!empty($config)) {
        $make = new Make($config);
        $content = $make->getNginxConfig();
        if ($make->checkFileAndDir() && !empty($content)) {
            $make->makeSiteDir();
            $make->writeNginxConfigFile($content);
        }
    } else {
        throw new \Exception('invalid options(main)');
    }
} catch (\Exception $e) {
    fwrite(STDOUT, 'Error: ' . $e->getMessage() . PHP_EOL);
}
