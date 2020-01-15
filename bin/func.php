<?php
/**
 * 复制整个目录,包含子文件夹
 * copy_dir('e:/copy/tpl', 'e:/copy/tpl_copy');
 * @authname [权限名字]     0
 * @DateTime 2018-12-25
 * @Author   mokuyu
 *
 * @param  [type]   $src [description]
 * @param  [type]   $des [description]
 * @return [type]
 */
// function copy_dir($src, $des)
// {
//     $dir = opendir($src);
//     if (!is_dir($des)) {
//         mkdir($des, 777, true);
//     }
//     while (false !== ($file = readdir($dir))) {
//         if (($file != '.') && ($file != '..')) {
//             if (is_dir($src . '/' . $file)) {
//                 copy_dir($src . '/' . $file, $des . '/' . $file);
//             } else {
//                 copy($src . '/' . $file, $des . '/' . $file);
//             }
//         }
//     }
//     closedir($dir);
// }

function cli_write_file($path, $data)
{
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path));
    }
    file_put_contents($path, $data);
}

function getRequireName($str, $isRequire = true)
{
    while (true) {
        $anw = getChar($str);
        if ($isRequire && !preg_match('/[\w\d\-\_]{3,10}/', $anw, $mat)) {
            echo "\r";
            continue;
        }

        return $anw;
    }
}

function loadlib($file = '')
{
    $filePath = __dir__ . '/../src/' . ucwords($file) . '.php';
    if (!is_file($filePath)) {
        return false;
    }
    require_once __dir__ . '/../src/Base.php';
    require_once $filePath;
    $name = 'ank\\cli\\' . ucwords($file);

    return new $name();
}

/**
 * 字符串命名风格转换
 * type 0 将 Java 风格转换为 C 的风格(UserGroup=>user_group) 1 将 C 风格转换为 Java 的风格user_group=>UserGroup
 * @access public
 * @param  string   $name    字符串
 * @param  integer  $type    转换类型
 * @param  bool     $ucfirst 首字母是否大写（驼峰规则）
 * @return string
 */
function parse_name($name, $type = 0, $ucfirst = true)
{
    if ($type) {
        $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
            return strtoupper($match[1]);
        }, $name);

        return $ucfirst ? ucfirst($name) : lcfirst($name);
    }

    return strtolower(trim(preg_replace('/[A-Z]/', '_\\0', lcfirst($name)), '_'));
}

/**
 * 自动创建一个app(composer)目录结构
 * @authname [权限名字]     0
 * @DateTime 2019-08-30
 * @Author   mokuyu
 *
 * @param  [type]   $src        [description]
 * @param  [type]   $des        [description]
 * @param  [type]   $moduleName [description]
 * @return [type]
 */
function copy_dir(string $src, string $des, array $rearr = [])
{
    $dir = opendir($src);
    if (!is_dir($des)) {
        mkdir($des, 777, true);
    }
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copy_dir($src . '/' . $file, $des . '/' . $file, $rearr);
            } else {
                $s_path = $src . '/' . $file;
                $d_path = $des . '/' . $file; //str_replace('.tpl', '.php', $file);

                //对路径中的模块进行替换成目录
                $d_path = strtr($d_path, $rearr);
                $str    = file_get_contents($s_path);
                $str    = strtr($str, $rearr);
                cli_write_file($d_path, $str);
            }
        }
    }
    closedir($dir);
}

function getChar($question)
{
    echo $question;
    while (!feof(STDIN)) {
        $line = fread(STDIN, 1024);

        return trim($line);
    }
}

function clilog($str = '')
{
    echo $str, PHP_EOL;
    flush();
}
