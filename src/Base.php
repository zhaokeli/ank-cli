<?php
namespace ank\cli;

use ank\App;

/**
 * 自动化生成工具
 */
class Base
{
    protected $app = null;

    protected $db = null;

    protected $workDir = null;

    public function __construct()
    {
        $this->workDir = getcwd();
        $this->app     = App::getInstance([
            'siteRoot' => realpath($this->workDir . '/web'),
            'appPath'  => realpath($this->workDir),
        ]);
        $this->db = $this->app->get('db');
    }

    protected function run()
    {

    }
}
