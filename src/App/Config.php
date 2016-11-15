<?php

namespace Rocketx\App;

class Config
{
    protected $configFile;
    protected $optionsCli;

    protected function getSettingsFile() {
        $this->configFile = json_decode(file_get_contents('config/config.json'));
        //TODO: проверить все переменные в конфиги через Swish - с выволом ошибки
        if (empty((array)$this->configFile)) {
            throw new Exception('Parse json error - ' . json_last_error_msg());
        }
    }

    protected function getOptionsCli() {
        // TODO: сменить название и подумать как переделать отвественность
        $options = [
            'd:' => 'domain:',
            't:' => 'template:',
            'h::' => 'help::',
            'l::' => 'list::'
        ];
        $this->optionsCli = getopt(implode('', array_keys($options)), $options);
    }
}
