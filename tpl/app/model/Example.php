<?php
namespace model;

use ank\Model;

/**
 *Example模型
 */
class Example extends Model
{
    //自动添加的字段，如果是键值对,则值就是这个字段的值，如果只有一个字段则自动查找set[Field]Attr方法来设置这个字段
    protected $auto   = []; //添加更新都附加上去
    protected $insert = []; //添加时附加上去
    protected $update = []; //更新时附加上去

    //添加下面这个方法是为啦方便,因为数据库可以自动过滤post数据添加到数据库,
    //添加下面字段能让让模型类在发送到数据库前先自动删除不想让更新或添加的字段,比如客户编号,用户uid等字段，后期可以使用场景scene来完成
    protected $beforeInsertDelete = []; //添加时要删除的字段
    protected $beforeUpdateDelete = []; //更新时要删除的字段

    //下面都是默认的值
    protected $tableName = '';
    protected $join      = [];
    protected $fields    = [];
    protected $where     = [];
    protected $limit     = '';
    protected $order     = '';
}
