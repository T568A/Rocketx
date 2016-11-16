<?php

namespace Rocketx\App;

class PrintCli
{
    public static function getHelp()
    {
        ob_start();
        require __DIR__ . '/../../help.txt';
        fwrite(STDOUT, ob_get_clean());
    }

    public static function getTemplateList($path)
    {
        foreach (new \DirectoryIterator(__DIR__ . $path) as $file) {
            if (!$file->isDot()) {
                fwrite(STDOUT, $file->getFilename());
            }
        }
    }
}