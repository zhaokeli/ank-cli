<?php
namespace ank\cli;

/**
 * 自动化生成工具
 */
class Preload extends Base
{
    //忽略的目录 文件 正则使用 /表达式/ 后面不加修饰符
    protected $ignores = ['Psr/Log/Test', 'doctrine/cache/tests', 'doctrine/event-manager/tests', 'ramsey/uuid/tests', 'tpl', '.git', '.idea', '.vscode', 'logs', 'uploads', 'static', 'public', 'example', 'Example',
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
        '/bin/',
    ];

    //预加载的脚本目录全路径路径
    protected $paths = [

    ];

    //预加载的脚本后缀
    protected $suffix = ['.php'];

    public function __construct()
    {
        parent::__construct();
        $config = $this->app->config('preload') ?: [];
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

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
        $list = [];
        foreach ($this->paths as $key => $value) {
            $list = array_merge($list, $this->loopDir($value));
        }
        //把没有依赖没有继承的放前面加载
        //interface
        // $interfaces     = [];
        // $aloneClasses   = [];
        // $extendsClasses = [];
        // foreach ($list as $key => $value) {
        //     if (strpos($value, 'TranslationWriterInterface') !== false) {
        //         echo 'run';
        //     }
        //     $content = file_get_contents($value);
        //     if (preg_match('/\s+interface\s+[\w\d_]+/i', $content, $mat)) {
        //         $interfaces[] = $value;
        //     } else if (preg_match('/\n\s*class\s+[\w\d_]+\n/i', $content, $mat)) {
        //         $aloneClasses[] = $value;
        //     } else {
        //         $extendsClasses[] = $value;
        //     }
        // }
        // $list = array_merge($interfaces, $aloneClasses, $extendsClasses);
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
