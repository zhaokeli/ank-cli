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
function copyDir($src, $des)
{
    $dir = opendir($src);
    Utils::mkdir($des);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copyDir($src . '/' . $file, $des . '/' . $file);
            } else {
                copy($src . '/' . $file, $des . '/' . $file);
            }
        }
    }
    closedir($dir);
}
