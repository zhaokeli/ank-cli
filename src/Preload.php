<?php
namespace ank\cli;

/**
 * 自动化生成工具
 */
class Preload extends Base
{
    //忽略的目录 文件 正则使用 /表达式/ 后面不加修饰符
    protected $ignores = ['Psr/Log/Test', 'doctrine/cache/tests', 'doctrine/event-manager/tests', 'ramsey/uuid/tests', 'lang', 'tpl', '.git', '.idea', '.vscode', 'logs', 'uploads', 'static', 'public',
        '/doctrine/inflector/tests',
        '/doctrine/migrations/tests',
        '/symfony/console/Tests',
        '/symfony/debug/Tests',
        '/symfony/finder/Tests',
        '/symfony/translation/Tests',
        '/aliyuncs/oss-sdk-php/tests',
        '/aliyuncs/oss-sdk-php/samples',
        '/symfony/translation-contracts/Test',
        '/jakub-onderka/php-console-color/tests',
        '/views',
    ];

    protected $proloadConfig = [];

    protected $suffix = ['.php'];

    public function loopDir($dir)
    {
        $dirList = [];
        if (!is_dir($dir)) {
            return [];
        }
        $handle = opendir($dir);
        while ($handle && false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                if ($this->isIgnore($dir, $file)) {
                    continue;
                }
                if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                    $dirList = array_merge($dirList, $this->loopDir($dir . DIRECTORY_SEPARATOR . $file));
                } else {
                    if (in_array(substr($file, -4), $this->suffix)) {
                        $dirList[] = realpath($dir . DIRECTORY_SEPARATOR . $file);
                    }
                }
            }
        }
        $handle && closedir($handle);

        return $dirList;
    }

    public function run()
    {
        $list = array_merge(
            $this->loopDir($this->workDir . '/vendor/aliyuncs'),
            $this->loopDir($this->workDir . '/vendor/ramsey'),
            $this->loopDir($this->workDir . '/vendor/psr'),
            $this->loopDir($this->workDir . '/vendor/ank/admin-alioss'),
            $this->loopDir($this->workDir . '/vendor/ank/framework'),
            $this->loopDir($this->workDir . '/vendor/ank/admin-base'),
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

    private function isIgnore($dir = '', $file = '')
    {
        $fullpath = str_replace('\\', '/', $dir . DIRECTORY_SEPARATOR . $file);
        foreach ($this->ignores as $key => $value) {
            if (strpos($value, '/') === 0 && substr($value, -1) == '/' && preg_match($value . 'i', $fullpath, $mat)) {
                return true;
            }
            if (strpos($fullpath, $value) !== false) {
                return true;

            }
            if ($value == $file) {
                return true;
            }

        }

        return false;
    }
}
