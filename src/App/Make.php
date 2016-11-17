<?php
declare(strict_types = 1);

namespace Rocketx\App;

class Make
{
    private $config;
    private $pathSiteDir;
    private $fullNameConfigFile;
    private $symlinkFullNameConfigFile;
    private $fullNameTemplateFile;

    public function __construct(\stdClass $config)
    {
        $this->config                       = $config;
        $this->pathSiteDir                  = $this->config->script->baseSitesDir . $this->config->site->domain;
        $this->fullNameConfigFile           = $this->config->nginx->dirSitesAvailable . $this->config->site->domain . '.conf';
        $this->symlinkFullNameConfigFile    = $this->script->nginx->dirSitesEnabled . $this->config->site->domain . '.conf';
        $this->fullNameTemplateFile         = __DIR__ . $this->config->script->templatesDir . '/' . $this->config->script->nameTemplateFile;
    }

    public function checkFileAndDir()
    {
        // add dirSitesAvailable
        if (!file_exists($this->pathSiteDir) && !file_exists($this->fullNameConfigFile)) {
            return true;
        } else {
            throw new \Exception('The directory or file already exists!(checkFileAndDir)');
        }
    }

    public function getNginxConfig()
    {
        if (is_readable($this->fullNameTemplateFile)) {
            ob_start();
            require_once $this->fullNameTemplateFile;
            return ob_get_clean();
        } else {
            throw new \Exception('Template not found!(getNginxConfig)');
        }
    }

    public function makeSiteDir()
    {
        if (!mkdir($this->pathSiteDir, 0770, true)) {
            throw new \Exception('The directory or file already exists!(makeSiteDir)');
        }
        if (!chown($this->pathSiteDir, $this->config->script->user)) {
            throw new \Exception('permission denied!(user - makeSiteDir)');
        }
        if (!chgrp($this->pathSiteDir, $this->config->script->group)) {
            throw new \Exception('permission denied!(group - makeSiteDir)');
        }
        return true;
    }

    public function writeNginxConfigFile(string $content)
    {
        if (!empty($content) && !file_exists($this->fullNameConfigFile)) {
            // add dirSitesAvailable
            if (!file_put_contents($this->fullNameConfigFile, $content)) {
                throw new \Exception('file write - fail!(writeNginxConfigFile)');
            }
        } else {
            throw new \Exception('file write - fail!(writeNginxConfigFile)');
        }
    }

    public function makeSymlink()
    {
        if (file_exists($this->fullNameConfigFile)) {
            if (!symlink($this->fullNameConfigFile, $this->symlinkFullNameConfigFile)) {
                throw new \Exception('create symlink - fail!(makeSimlink)');
            }
        } else {
            throw new \Exception('file not exist - fail!(makeSimlink)');
        }
    }
}
