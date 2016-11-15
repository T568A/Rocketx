<?php

namespace Rocketx\App;

class Make
{
    private $config;

    function __construct($config)
    {
        $this->config = $config;
    }

    private function checkFileAndDir()
    {

        //если все хорошо вернуть true;
    }

    public function getNginxConfig()
    {
        $file = __DIR__ . '/templates/' . $this->config->script->nameTemplateFile;
        if (is_readable($file)) {
            ob_start();
            require_once $file;
            return ob_get_clean();
        } else {
            throw new Exception('Template not found!');
        }
    }

    public function makeSiteDir()
    {
        if (!mkdir($this->config->script->baseSitesDir . $this->config->site->domain, 0770, true)) {
            throw new Exception('The directory or file already exists!');
        }
        return true;
    }

    public function writeNginxConfigFile()
    {
        $content = $this->getNginxConfig();
        $file = $config->site->domain . '.conf';
        if (!empty($content) && !file_exists($file)) {
            // добавить путь к $file
            return file_put_contents($file, $content);
        } else {
            throw new Exception('writeNginxConfigFile');
        }
    }

    public function getConfig()
    {
        return $this->config;
    }
}
