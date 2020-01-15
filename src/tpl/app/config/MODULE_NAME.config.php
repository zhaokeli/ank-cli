<?php
/**
 * MODULE_NAME模块的配置文件,文件名可自定义
 * 此目录可以有多个配置文件,关闭调试模式后自动合并到缓存中保存
 * 所有配置项键都使用小写
 */
return [
    'template_replace_str' => [
        '__STATIC__' => '/public/static',
        '__IMG__'    => '/public/MODULE_NAME/default/images',
        '__CSS__'    => '/public/MODULE_NAME/default/css',
        '__JS__'     => '/public/MODULE_NAME/default/js',
    ],
];