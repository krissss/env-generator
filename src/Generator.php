<?php

namespace kriss\envGenerator;

abstract class Generator extends BaseObject
{
    /**
     * @var string
     */
    public $generateFilePath;
    /**
     * @var Env
     */
    public $baseEnv;
    /**
     * @var array
     */
    public $envConf;

    public function run()
    {
        foreach ($this->envConf as $env => $envObj) {
            // 清空环境目录
            $this->removeDirectory($this->getEnvFilePath($env));
            // 合并环境配置和基础配置
            /** @var $envObj Env */
            $config = Tools::nestedMerge($this->baseEnv->config, $envObj->config);
            // 替换配置中的变量
            $config = Tools::replaceAttribute($config, $config);
            // 生成配置文件
            $this->generateFiles($config, $env, $envObj);
        }
    }

    /**
     * 生成文件，可以使用如下方法辅助
     * fileGenerate($env, $fileName, $content)：文件生成
     *
     * @param array $config
     * @param string $env
     * @param Env $envObj
     */
    abstract protected function generateFiles($config, $env, $envObj);

    /**
     * env 文件的路径
     * @param string $env
     * @return string
     */
    protected function getEnvFilePath($env)
    {
        return rtrim($this->generateFilePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $env;
    }

    /**
     * 删除文件夹
     * @param $dir
     */
    protected function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }
        if (!($handle = opendir($dir))) {
            return;
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $this->removeDirectory($path);
            } else {
                unlink($path);
            }
        }
        closedir($handle);
        rmdir($dir);
    }

    /**
     * 生成文件
     * @param $env
     * @param $fileName
     * @param $content
     */
    protected function fileGenerate($env, $fileName, $content)
    {
        $path = $this->getEnvFilePath($env);
        if (!is_dir($path)) {
            mkdir($path);
        }
        file_put_contents($path . DIRECTORY_SEPARATOR . $fileName, $content);
    }
}