<?php

namespace Rocketx\App;

class Config
{
    private $domain;
    private $template;
    private $config;

    private function getSettingsFile() {
        $this->config = json_decode(file_get_contents('config/config.json'));
        //TODO: проверить все переменные в конфиги через Swish - с выволом ошибки
        if (empty((array)$this->config)) {
            throw new Exception('Parse json error - ' . json_last_error_msg());
        }

    }

    private function getOptionsCli() {
        // TODO: сменить название и подумать как переделать отвественность
        $options = [
            'd:' => 'domain:',
            't:' => 'template:',
            'h::' => 'help::',
            'l::' => 'list::'
        ];
        $options = getopt(implode('', array_keys($options)), $options);

        if (empty($options)) {
            fwrite(STDOUT, 'Enter Domain (example.com):');
            $line1 = trim(fgets(STDIN));
            fwrite(STDOUT, 'Enter Template (example.tmp):');
            $line2 = trim(fgets(STDIN));
            $this->domain = (!empty($line1)) ? $line1 : 'example.com';
            $this->template = (!empty($line2)) ? $line2 : 'example.tmp';
        } else {
            $this->domain = $options['domain'] ?? $options['d'] ?? NULL;
            $this->template = $options['template'] ?? $options['t'] ?? NULL;
        }

        if (isset($options['help']) || isset($options['h'])) {
            ob_start();
            require 'help.txt';
            echo ob_get_clean();
        }

        if (isset($options['list']) || isset($options['l'])) {
            //TODO: сменить на абсолютный путь (или посмотреть как лучше сделать относительный)
            foreach (new \DirectoryIterator(__DIR__ . $this->config->script->templatesDir) as $file) {
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
            $this->config->site->domain = $this->domain;
            $this->config->script->nameTemplateFile = $this->template;
            return $this->config;
        } else {
            return;
        }
    }
}
