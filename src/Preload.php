<?php
namespace ank\cli;

/**
 * 自动化生成工具
 */
class Preload extends Base
{
    protected $ignoreDir = ['lang', 'tpl', '.git', '.idea', 'vendor', '.vscode', 'logs', 'uploads', 'static', 'public'];

    protected $ignoreFiles = ['config.php', 'helper.php'];

    protected $proloadConfig = [];

    public function loopDir($dir)
    {
        $dirList = [];
        $handle  = opendir($dir);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                    if (!in_array($file, $this->ignoreDir)) {
                        $dirList = array_merge($dirList, $this->loopDir($dir . DIRECTORY_SEPARATOR . $file));
                    }

                } else {
                    if (!in_array($file, $this->ignoreFiles) && substr($file, -3) == 'php') {
                        $dirList[] = realpath($dir . DIRECTORY_SEPARATOR . $file);
                    }
                }
            }
        }
        closedir($handle);

        return $dirList;
    }

    public function run()
    {
        $list = array_merge(
            $this->loopDir($this->workDir . '/vendor/ramsey'),
            $this->loopDir($this->workDir . '/vendor/psr'),
            $this->loopDir($this->workDir . '/vendor/ank/framework'),
            $this->loopDir($this->workDir . '/vendor/ank/extend'),
            $this->loopDir($this->workDir . '/vendor/ank/image'),
            $this->loopDir($this->workDir . '/vendor/ank/iplookup'),
            $this->loopDir($this->workDir . '/vendor/ank/template'),
            $this->loopDir($this->workDir . '/vendor/illuminate'),
            $this->loopDir($this->workDir . '/vendor/duncan3dc'),
            $this->loopDir($this->workDir . '/vendor/doctrine'),
            $this->loopDir($this->workDir . '/vendor/mokuyu'),
            $this->loopDir($this->workDir . '/vendor/symfony'),
            $this->loopDir($this->workDir . '/vendor/jakub-onderka')
        );
        array_walk($list, function (&$value, $key) {
            $value = str_replace([$this->workDir . DIRECTORY_SEPARATOR . 'vendor', '\\'], ['__DIR__ . \'', '/'], $value);
        });
        $preloadTpl = file_get_contents(__dir__ . '/tpl/preload.php');
        $filesList  = implode('\',' . PHP_EOL . '    ', $list);
        $str        = <<<eot
\$filesList=[
    {$filesList}',
];
eot;

        file_put_contents($this->workDir . '/vendor/preload.php', str_replace('//preloadarray', $str, $preloadTpl));
        clilog('success create preload ' . count($list) . ' files');

    }
}
