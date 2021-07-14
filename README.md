# Aliyun-OSS

## Tpextbuilder的阿里云-OSS驱动

### 请使用composer安装**阿里云OSS-sdk**后再安装本扩展

```bash
composer require aliyuncs/oss-sdk-php
```

### 注意事项

- 存储权空间的命名，应该**个性化**，避免名称被其他用OSS户占用。

    如`tpext1626077257123.oss-cn-hangzhou.aliyuncs.com`中`tpext1626077257123`是空间名，`oss-cn-hangzhou.aliyuncs.com`是数据中心访问域名。

- 你可以事先在阿里云控制台创建好存储空间，然后填入配置里面。

- 存储权空间限有三种[私有/公共读/公共读写]，建议设置为：**公共读**。

- 填入的数据中心访问域名要和空间匹配，比如你在[杭州oss-cn-hangzhou.aliyuncs.com]

    创建的空间，访问域名不能填[北京oss-cn-beijing.aliyuncs.com]。

- 如果没有事先创建，会按填写的[空间名称]和[数据中心访问域名]和[存储权公共读]自动创建一个。

- 可选的访问域名：

    <https://help.aliyun.com/document_detail/31837.htm?spm=a2c4g.11186623.2.4.19225338SL9VT9#concept-zt4-cvy-5db>

### 使用

1. 全局设置

    在扩展`tpext ui生成(tpext.builder)`的配置里面选择本驱动：[阿里云OSS存储]，保存，设置后所有的文件上传都使用阿里云OSS。

2. 单独使用
    ckeditor,mdeditor,tinymce,ueditor,file,image,multipleFile,multipleImage等可使用`storageDriver($class)`方法单独设置。

```php

$form->image('logo', '封面图')->mediumSize()->storageDriver(\aliyunoss\common\OssStorage::class);//使用阿里云oss存储

$form->file('file', '附件')->mediumSize()->storageDriver(\tpext\builder\logic\LocalStorage::class);//服务器本地存储
```
