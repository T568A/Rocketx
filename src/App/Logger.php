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
        $this->message = date('Y-m-d H:i:s') . ': ' . $message;
    }

    public function writeLog()
    {
        file_put_contents($this->fullNameLogFile, $this->message, FILE_APPEND);
    }



}
