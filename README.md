# ENV generator

## 使用

### 1. 创建生成类，实现生成配置文件的逻辑

创建一个类，继承自 \kriss\envGenerator\Generator

例如：

```php
<?php

namespace test\test;

class Generator extends \kriss\envGenerator\Generator
{
    protected function generateFiles($config, $env, $envObj)
    {
        $commonHeader = '# this file is generated by ' . __CLASS__;
        $content = $this->getEnvProject($config);
        $this->fileGenerate($env, '.env', implode("\n", [$commonHeader, $content]));
    }
    
    protected function getEnvProject($config) {
        return <<<EOL
ENV={$config['env']}
        
APP_KEY={$config['appKey']},
APP_SECRET={$config['appSecret']},
EOL;
    }
}
```

### 2. 创建配置和生成代码

例如：

```php
<?php

use kriss\envGenerator\Env;
use kriss\envGeneratorExample\Generator;

require __DIR__ . '/vendor/autoload.php';

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
```

## 更多使用见 test