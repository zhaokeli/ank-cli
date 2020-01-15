<?php

namespace validate;

use ank\Validate;

/**
 * api验证类
 */
class Example extends Validate
{
    //对指定字段进行规则验证
    protected $rule = [
        //必填项,纯字母,最大25个字符,并且不能重复
        'title'         => 'require|alpha|max:25|unique:Form',
        //验证某个字段的值是否为字母和数字，下划线_及破折号-，alphaNum 字母和数据
        'name'          => 'alphaDash',
        //纯数字,在0到100之间 相反使用 notBetween
        'sort'          => 'number|between:0,100',
        // 验证某个字段的值是否为浮点数字（采用filter_var验证），例如：
        'sort'          => 'float',
        // 验证某个字段的值是否为email地址（采用filter_var验证），例如：
        'email'         => 'email',
        'title'         => 'require|max:25|unique:Menu',
        //只能是汉字且长度在6到20之间,
        //chsAlpha汉字字母
        //chsDash 验证某个字段的值只能是汉字、字母、数字和下划线_及破折号-
        //chsAlphaNum 验证某个字段的值只能是汉字、字母和数字，例如：
        'username'      => 'chs|length:6,20',
        // 验证某个字段的值是否在某个范围，例如：相反使用 notIn
        'num'           => 'in:1,2,3',
        //验证是否为指定日期格式
        'create_time'   => 'dateFormat:y-m-d',
        //是否有效身份格式
        'id_card'       => 'idCard', //待查证是否支持
        //是否有效手机号
        'mobile'        => 'mobile',
        //验证两个字段是否一至
        'repassword'    => 'confirm:password',
        //正则验证
        'zip'           => 'regex:\d{6}',
        //如果你的正则表达式中包含有|符号的话，必须使用数组方式定义。
        'accepted'      => ['regex' => '/^(yes|on|1)$/i'],
        'nickname'      => 'require|length:2,20',
        'user_group_id' => 'require|number',
        'pid'           => 'gt:0',
    ];

    //如果验证不通过后提示的信息
    protected $message = [
        'title.require'  => '表单标题不能为空',
        'title.unique'   => '表单标题已经存在',
        'name.alphaDash' => '数据表一定要是字母',
        'name.max'       => '数据表最多不能超过25个字符',
        'name.unique'    => '数据表名字已经存在',
        'sort.number'    => '排序必须是数字',
        'sort.between'   => '排序只能在0-100之间',
    ];

    //设置验证场景,只对指定字段进行验证
    protected $scene = [
        'add'  => ['name', 'email'],
        'edit' => [
            'title' => 'require|max:25',
            'name'  => 'alphaDash|max:25',
            'sort'  => 'number|between:0,100',
        ],
    ];
}
