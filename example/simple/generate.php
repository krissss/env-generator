<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . 'EnvGenerator.php';

(new \EnvGenerator([
    'generateFilePath' => __DIR__,
    'baseEnv' => [
        'desc' => '基础配置',
        'config' => [
            'env' => 'prod',
            'appKey' => '123456',
            'appSecret' => 'secret123456'
        ],
    ],
    'envConf' => [
        'dev' => [
            'desc' => '开发环境',
            'config' => [
                'env' => 'dev',
            ],
        ],
        'prod' => [
            'desc' => '正式环境',
            'config' => [
                'appKey' => '1234567',
                'appSecret' => 'secret1234567'
            ],
        ],
    ],
]))->run();