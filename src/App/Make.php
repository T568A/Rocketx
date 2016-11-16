<?php

namespace Rocketx\App;

class Make
{
    private $config;
    private $pathSiteDir;
    private $nameConfigFile;

    public function __construct($config)
    {
        $this->config           = $config;
        $this->pathSiteDir      = $this->config->script->baseSitesDir . $this->config->site->domain;
        $this->nameConfigFile   = $this->config->site->domain . '.conf';
    }

    public function checkFileAndDir()
    {
        // add dirSitesAvailable
        if (!file_exists($this->pathSiteDir) && !file_exists($this->nameConfigFile)) {
            return true;
        } else {
            throw new \Exception('File or Directory exists');
        }
    }

    public function getNginxConfig()
    {
        $file = __DIR__ . $this->config->script->templatesDir . '/' . $this->config->script->nameTemplateFile;
        if (is_readable($file)) {
            ob_start();
            require_once $file;
            return ob_get_clean();
        } else {
            throw new \Exception('Template not found!');
        }
    }

    public function makeSiteDir()
    {
        if (!mkdir($this->pathSiteDir, 0770, true)) {
            throw new \Exception('The directory or file already exists!');
        }
        return true;
    }

    public function writeNginxConfigFile($content)
    {
        if (!empty($content) && !file_exists($this->nameConfigFile)) {
            // add dirSitesAvailable
            return file_put_contents($this->nameConfigFile, $content);
        } else {
            throw new \Exception('writeNginxConfigFile');
        }
    }

    public function getConfig()
    {
        return $this->config;
    }
}
