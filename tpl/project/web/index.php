<?php
//包含自动加载类
$loader = require __DIR__ . '/../vendor/autoload.php';
//框架入口
\ank\App::start()->send();
