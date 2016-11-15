<?php

namespace Rocketx\App;

class DataProcessing extends Config
{

private $domain;
private $template;

protected function getOptionsCli() {
    parent::getOptionsCli();
    if (empty($this->optionsCli)) {
        fwrite(STDOUT, 'Enter Domain (example.com):');
        $line1 = trim(fgets(STDIN));
        fwrite(STDOUT, 'Enter Template (example.tmp):');
        $line2 = trim(fgets(STDIN));
        $this->domain = (!empty($line1)) ? $line1 : 'example.com';
        $this->template = (!empty($line2)) ? $line2 : 'example.tmp';
    } else {
        $this->domain = $this->optionsCli['domain'] ?? $this->optionsCli['d'] ?? NULL;
        $this->template = $this->optionsCli['template'] ?? $this->optionsCli['t'] ?? NULL;
    }

    if (isset($this->optionsCli['help']) || isset($this->optionsCli['h'])) {
        ob_start();
        require 'help.txt';
        echo ob_get_clean();
    }

    if (isset($this->optionsCli['list']) || isset($this->optionsCli['l'])) {
        //TODO: сменить на абсолютный путь (или посмотреть как лучше сделать относительный)
        foreach (new \DirectoryIterator(__DIR__ . $this->configFile->script->templatesDir) as $file) {
            if (!$file->isDot()) {
                fwrite(STDOUT, $file->getFilename());
            }
        }
    }
}

public function getConfig() {
        $this->getSettingsFile();
        $this->getOptionsCli();
        if (!empty($this->domain) && !empty($this->template)) {
            $this->configFile->site->domain = $this->domain;
            $this->configFile->script->nameTemplateFile = $this->template;
            return $this->configFile;
        } else {
            return;
        }
    }
}
