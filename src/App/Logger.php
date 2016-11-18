<?php
declare(strict_types = 1);

namespace Rocketx\App;

class Logger
{
    private $message;
    private $fullNameLogFile;

    public function __construct(string $path, string $message)
    {
        $this->fullNameLogFile = $path . 'rocketx.log';
        $this->message = $message . PHP_EOL;
    }

    public function writeLog()
    {
        syslog(LOG_ERR, 'Rocketx: ' . $this->message);
        file_put_contents($this->fullNameLogFile, date('Y-m-d H:i:s') . ': ' . $this->message, FILE_APPEND);
    }
}
