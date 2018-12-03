<?php

use kriss\envGenerator\Env;
use kriss\envGeneratorExample\simple\Generator;

require __DIR__ . '/../../vendor/autoload.php';

(new Generator([
    'generateFilePath' => __DIR__,
    'baseEnv' => new Env([
        'desc' => '基础配置',
        'config' => [
            'env' => 'prod',
            'appKey' => '123456',
            'appSecret' => 'secret123456'
        ],
    ]),
    'envConf' => [
        'dev' => new Env([
            'desc' => '开发环境',
            'config' => [
                'env' => 'dev',
            ],
        ]),
        'prod' => new Env([
            'desc' => '正式环境',
            'config' => [
                'appKey' => '1234567',
                'appSecret' => 'secret1234567'
            ],
        ]),
    ],
]))->run();