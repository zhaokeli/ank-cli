<?php

return [
    //////////////以下配置只在此配置文件中有效，不能放到其它模块配置文件中,因为要预加载///////////////////
    ///建议自己的配置放在同目录其它文件中，文件名可自定义,会自动加载合并
    'default_module'    => 'MODULE_NAME',
    'app_debug'         => false,
    'app_trace'         => true,
    'allow_module_list' => ['admin', 'index', 'wuliu', 'api'],
    //如时此项为true的话,在开发模式时，每次执行sql时会判断表里有没有 create_time,update_time,auto_create_time,auto_update_time没有的话会自动添加到表里,有插入或更新操作时create_time，update_time字段如果没有设置时会自动添加上值
    'auto_time_fields'  => true,
    //伪静态的时候使用url路由功能
    'url_route'         => [
        // 路由规则为整个字符串的完全匹配
        // 路由规则参数格式为 :参数名,影射到 模块/控制器/操作(三个都不能少)
        // 只要当前或生成的url符合后面的操作方法路径就可以匹配转换
        // 键中没有标记出来的参数会在后面加?a=1&b=2这样的格式
        'news/:id'               => 'admin/index/index',
        //下面是两种方法
        'sajax/:action'          => 'admin/sys.ajax/index',
        'sajax/:action/:menu_id' => 'admin/sys.ajax/index',
    ],
    'template'          => [
        'type'        => \ank\driver\view\Think::class,
        // 'type'        => \ank\driver\view\Smarty::class,
        // 'type'        => \ank\driver\view\Blade::class,
        //模板目录名字
        'view_dir'    => 'views',
        // 模板额外的路径,不用加后面的views
        // 因为视图路径是根据控制器子级到父级的位置自动定位的，如果有定位不到的路径可以在下面添加
        'view_path'   => [],
        // 模板后缀
        'view_suffix' => 'html',
        // 标签库标签开始标记
        'tag_begin'   => '{',
        // 标签库标签结束标记
        'tag_end'     => '}',
        // 是否去除模板文件里面的html空格与换行
        'strip_space' => true,
        //根目录为运行时路径
        'cache_path'  => '/tplcache',
    ],
    //数据库配置
    'db_config'         => [
        // 必须配置项
        'database_type'   => 'mysql',
        'database_name'   => 'ank_crm',
        'server'          => '127.0.0.1',
        'username'        => 'root',
        'password'        => 'HEli8888-_-mYsql',
        'charset'         => 'utf8',
        'port'            => 3306,
        'prefix'          => 'kl_',
        'slow_query_time' => 2000,
        'debug'           => true,
        'cache'           => true,
        // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
        // 'option'        => [
        //     PDO::ATTR_CASE => PDO::CASE_NATURAL,
        // ],
    ],
    'cache'             => [
                                // 缓存类型为File
        'type'      => 'redis', //目前支持file和memcache redis
        'memcache'  => [
            'host' => '127.0.0.1',
            'port' => 11211,
        ],
        'redis'     => [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'index'    => 0,
            'password' => '',
        ],
        // 全局缓存有效期（0为永久有效）
        'expire'    => 0,
        'temp_time' => 60, //单位秒
                           // 缓存前缀
        'prefix'    => 'ank_crm_',
        // 缓存目录
        'path'      => '/datacache',
    ],
    //当是下面ip的时候强制使用对应的配置来覆盖
    'ip_config'         => [
        '127.0.0.1'      => [
            'app_debug' => false,
            'app_trace' => true,
            //数据库配置
            'db_config' => [
                // 必须配置项
                'database_type'   => 'mysql',
                'database_name'   => 'ank_crm',
                'server'          => 'mysql.loc',
                'username'        => 'root',
                'password'        => 'adminrootkl',
                'charset'         => 'utf8',
                'port'            => 3306,
                'prefix'          => 'kl_',
                'slow_query_time' => 1000,
                'debug'           => true,
                'cache'           => true,
                // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
                // 'option'        => [
                //  PDO::ATTR_CASE => PDO::CASE_NATURAL,
                // ],
            ],
        ],
        '1.80.145.183'   => [
            'app_debug' => false,
            'app_trace' => true,
        ],
        '192.168.11.111' => [
            'app_debug' => true,
            'app_trace' => true,
        ],
    ],
    //针对不同的域名进行不同的配置,此域名配置会覆盖上面的ip配置
    'domain_config'     => [
        'ank.dbg'            => [
            'app_debug' => true,
            'app_trace' => true,
            'db_config' => [
                // 必须配置项
                'database_type'   => 'mysql',
                'database_name'   => 'ank_crm',
                'server'          => 'localhost',
                'username'        => 'root',
                'password'        => 'adminrootkl',
                'charset'         => 'utf8',
                'port'            => 3306,
                'prefix'          => 'kl_',
                'debug'           => true,
                'cache'           => true,
                'slow_query_time' => 2000,
                // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
                // 'option'        => [
                //  PDO::ATTR_CASE => PDO::CASE_NATURAL,
                // ],
            ],
        ],
        'ank.loc'            => [
            'app_debug' => false,
            'app_trace' => true,
        ],
        'ank.lix'            => [
            'app_debug' => true,
            'app_trace' => true,
        ],
        'crm.helihulian.com' => [
            'app_debug' => false,
            'app_trace' => true,
        ],
        'crm.zkeli.com'      => [
            'app_debug' => false,
            'app_trace' => true,
            //数据库配置
            'db_config' => [
                // 必须配置项
                'database_type'   => 'mysql',
                'database_name'   => 'ank_crm',
                'server'          => 'localhost',
                'username'        => 'root',
                'password'        => 'adminrootkl',
                'charset'         => 'utf8',
                'port'            => 3306,
                'prefix'          => 'kl_',
                'slow_query_time' => 2000,
                'debug'           => true,
                'cache'           => true,
                // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
                // 'option'        => [
                //     PDO::ATTR_CASE => PDO::CASE_NATURAL,
                // ],
            ],
        ],
    ],

    //域名映射到对应的模块,此设置可以省去url中的模块名字
    'domain_map'        => [
        // 'ank.loc'     => 'admin',
        // 'ank.dbg'     => 'admin',
        'api.ank.loc'        => 'api',
        'api.ank.dbg'        => 'api',
        'crm.helihulian.com' => 'admin',
        'crm.zkeli.com'      => 'admin',
    ],
    'cli_config'        => [
        'app_debug' => false,
        'app_trace' => false,
    ],

];
