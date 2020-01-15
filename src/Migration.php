<?php
namespace ank\cli;

/**
 * 自动化生成工具
 */
class Migration extends Base
{
    public function run()
    {
        $exePath = $this->workDir . '/vendor/bin/ank-db';
        if (!is_file($exePath)) {
            system('composer --working-dir=' . $this->workDir . ' require ank/migrations');
        }
        global $argv, $argc;
        array_shift($argv);
        array_shift($_SERVER['argv']);
        $argc -= 1;
        require_once $this->workDir . '/vendor/ank/migrations/bin/ank-db.php';

    }
}
