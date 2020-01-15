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
function copy_dir($src, $des)
{
    $dir = opendir($src);
    if (!is_dir($des)) {
        mkdir($des, 777, true);
    }
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copy_dir($src . '/' . $file, $des . '/' . $file);
            } else {
                copy($src . '/' . $file, $des . '/' . $file);
            }
        }
    }
    closedir($dir);
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
function create_app(string $src, string $des, string $moduleName)
{
    $dir = opendir($src);
    if (!is_dir($des)) {
        mkdir($des, 777, true);
    }
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                create_app($src . '/' . $file, $des . '/' . $file, $moduleName);
            } else {
                $s_path = $src . '/' . $file;
                $d_path = $des . '/' . str_replace('.tpl', '.php', $file);
                $d_path = str_replace('MODULE_NAME.', $moduleName . '/', $d_path);
                $str    = file_get_contents($s_path);
                $restr  = [
                    'MODULE_NAME' => $moduleName,
                ];
                $str = strtr($str, $restr);
                file_put_contents($d_path, $str);
            }
        }
    }
    closedir($dir);
}
