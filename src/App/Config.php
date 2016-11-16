<?php

namespace Rocketx\App;

class Config
{
    private $configFile;
    private $optionsCli;
    private $domain;
    private $template;

    private function getSettingsFile()
    {
        $this->configFile = json_decode(file_get_contents('config/config.json'));
        if (empty((array)$this->configFile)) {
            throw new \Exception('Parse json error - ' . json_last_error_msg());
        }
    }

    private function getOptionsCli()
    {
        $options = [
            'd:' => 'domain:',
            't:' => 'template:',
            'h::' => 'help::',
            'l::' => 'list::'
        ];
        $this->optionsCli = getopt(implode('', array_keys($options)), $options);

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
            $this->configFile->script->help = true;
        }

        if (isset($this->optionsCli['list']) || isset($this->optionsCli['l'])) {
            $this->configFile->script->list = true;
        }

    }

    public function getConfig()
    {
        $this->getSettingsFile();
        $this->getOptionsCli();

        if (!empty($this->configFile->script->help) || !empty($this->configFile->script->list)) {
            return $this->configFile;
        }

        if (!empty($this->domain) && !empty($this->template)) {
            $this->configFile->site->domain = $this->domain;
            $this->configFile->script->nameTemplateFile = $this->template;
            return $this->configFile;
        } else {
            return false;
        }
    }
}
