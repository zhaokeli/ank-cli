<?php
namespace controller\MODULE_NAME;

/**
 * 默认控制器
 */
class Index extends Base
{

    public function index()
    {
        echo '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ANK VANK_VERSION<br/><span style="font-size:30px">ANK简约功能框架,MODULE_NAME模块功能创建成功</span></p><span style="font-size:22px;">[ VANK_VERSION 版本由 <a href="http://www.zhaokeli.com" target="mokuyu">魔窟鱼</a> 独家发布 ]</span></div>';
    }
}