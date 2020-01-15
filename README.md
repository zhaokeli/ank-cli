# ank-cli

## 创建项目

``` bash
ank create project
```

## 自动生成模型类和验证类

一般情况下直接使用all就可以，如果类存在会自动跳过

``` bash
ank create all #生成模型和验证
ank create validate #生成验证类
ank create model #生成模型类
```

## 数据库迁移

数据库迁移使用的是 **doctrine/migrations** 库，详细的命令可以查看文档 <https://www.doctrine-project.org/projects/doctrine-migrations/en/2.2/index.html>，使用方法为 **ank db** 加对应的命令

``` bash
ank db 迁移命令
```
