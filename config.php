<?php

return [
    'access_key_id' => '',
    'access_key_secret' => '',
    'endpoint' => 'oss-cn-hangzhou.aliyuncs.com',
    'bucket_name' => 'tpext' . time() . mt_rand(100, 999),
    //
    //配置描述
    '__config__' => [
        'access_key_id' => ['type' => 'text', 'label' => 'AccessKeyId', 'size' => [2, 8], 'help' => '您从OSS获得的AccessKeyId'],
        'access_key_secret' => ['type' => 'text', 'label' => 'AccessKeySecret', 'size' => [2, 8], 'help' => '您从OSS获得的AccessKeySecret'],
        'endpoint' => ['type' => 'text', 'label' => 'Endpoint', 'size' => [2, 8], 'help' => '您选定的OSS数据中心访问域名或自定义访问域名，例如：oss-cn-hangzhou.aliyuncs.com'],
        'bucket_name' => ['type' => 'text', 'label' => 'BucketName', 'size' => [2, 8], 'help' => '存储空间名字，只能包括小写字母、数字和短划线'],
    ],
];