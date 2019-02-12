<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/EnvGenerator.php';

(new \EnvGenerator([
    'generateFilePath' => __DIR__,
    'baseEnv' => [
        'desc' => '基础配置',
        'config' => [
            'docker' => [
                'app' => [
                    'name' => 'app',
                    'image' => 'daocloud.io/krissss/docker-yii2_71',
                    'version' => 'v1.6-unzip',
                    'port' => 10080,
                    'appPath' => '/app/yii2advanced',
                    'composerPath' => '~/.composer',
                    'hasNginxConf' => true,
                    'hasPhpConf' => true,
                    'hasSupervisorConf' => false,
                ],
                'mysql' => [
                    'use' => true,
                    'name' => 'mysql',
                    'image' => 'mysql',
                    'version' => '5.7',
                    'hasMysqlConf' => true,
                    'dataPath' => '/mnt/yii2advanced/mysql_data',
                    'port' => 13306,
                    'rootPassword' => 'root@123892342',
                    'database' => 'yii2advanced',
                    'user' => 'yii2advanced',
                    'password' => 'yii2advanced@89024',
                ],
                'redis' => [
                    'use' => true,
                    'name' => 'redis',
                    'image' => 'redis',
                    'version' => '3.2',
                    'dataPath' => '/mnt/yii2advanced/redis_data',
                    'port' => 16379,
                    'bind' => '0.0.0.0',
                    'password' => 'yii2advanced@1238982324',
                ]
            ],
            'project' => [
                'yiiDebug' => 0,
                'yiiEnv' => 'prod',
                'cookieKey' => 'suibianshuru',
                'db' => [
                    'dsn' => 'mysql:host=${docker.mysql.name};port=3306;dbname=${docker.mysql.database}',
                    'username' => '${docker.mysql.user}',
                    'password' => '${docker.mysql.password}',
                ],
                'redis' => [
                    'host' => '${docker.redis.name}',
                    'port' => '6379',
                    'password' => '${docker.redis.password}',
                    'dbSession' => '10',
                    'dbCache' => '11',
                ],
                'components' => [
                ]
            ],
        ]
    ],
    'envConf' => [
        'dev' => [
            'desc' => '开发环境',
            'config' => [
                'docker' => [
                    'app' => [
                        'appPath' => 'D:\phpStudy\WWW\yii2advanced',
                        'composerPath' => 'C:\Users\<user>\AppData\Roaming\Composer',
                    ],
                    'mysql' => [
                        'dataPath' => 'D:\docker\yii2advanced\mysql_data',
                        'rootPassword' => 'root@128931237',
                        'password' => 'yii2advanced@12378243',
                    ],
                    'redis' => [
                        'dataPath' => 'D:\docker\yii2advanced\redis_data',
                        'password' => 'yii2advanced@123324',
                    ],
                ],
                'project' => [
                    'yiiDebug' => 1,
                    'yiiEnv' => 'dev',
                    'cookieKey' => 'jjkj1kj3j1239890aksdqwe',
                ],
            ],
        ],
        'prod' => [
            'desc' => '正式环境',
            'config' => [
                'docker' => [
                    'mysql' => [
                        'rootPassword' => 'root@923847213',
                        'password' => 'yii2advanced@342321113',
                    ],
                    'redis' => [
                        'password' => 'yii2advanced@1123324',
                    ],
                ],
                'project' => [
                    'cookieKey' => '12jlkjsd90898qjkl123',
                ],
            ],
        ],
        'test' => [
            'desc' => '正式环境',
            'config' => [
                'docker' => [
                    'mysql' => [
                        'use' => false,
                    ],
                    'redis' => [
                        'use' => false,
                    ],
                ],
                'project' => [
                    'cookieKey' => '12jlkjsd90898qjkl123',
                ],
            ],
        ]
    ],
]))->run();