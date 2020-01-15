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

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->db  = $this->app->get('db');
    }

    protected function run()
    {

    }
}
