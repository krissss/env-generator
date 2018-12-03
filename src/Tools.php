<?php

namespace kriss\fileGenerator;

class Tools
{
    /**
     * 合并嵌套数组
     * @param $a
     * @param $b
     * @return array|mixed
     */
    public static function nestedMerge($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            foreach (array_shift($args) as $k => $v) {
                if (is_int($k)) {
                    if (array_key_exists($k, $res)) {
                        $res[] = $v;
                    } else {
                        $res[$k] = $v;
                    }
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = static::nestedMerge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }

    /**
     * 替换配置文件中的变量 ${xxx.xxx}
     * @param $arr
     * @param $conf
     * @return array
     */
    public static function replaceAttribute($arr, $conf)
    {
        $res = [];
        foreach ($arr as $key => $data) {
            if (is_array($data)) {
                $data = static::replaceAttribute($data, $conf);
            } elseif (is_string($data)) {
                preg_match_all('/\${(.*)}/iU', $data, $matches);
                if (count($matches) == 2) {
                    $replaceArr = [];
                    foreach ($matches[1] as $match) {
                        $replaceArr[] = static::getArrayValue($conf, $match);
                    }
                    $data = strtr($data, array_combine($matches[0], $replaceArr));
                }
            }
            $res[$key] = $data;
        }
        return $res;
    }

    /**
     * 获取数组中的键值
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function getArrayValue($array, $key, $default = null)
    {
        if ($key instanceof \Closure) {
            return $key($array, $default);
        }

        if (is_array($key)) {
            $lastKey = array_pop($key);
            foreach ($key as $keyPart) {
                $array = static::getArrayValue($array, $keyPart);
            }
            $key = $lastKey;
        }

        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            return $array[$key];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = static::getArrayValue($array, substr($key, 0, $pos), $default);
            $key = substr($key, $pos + 1);
        }

        if (is_array($array)) {
            return (isset($array[$key]) || array_key_exists($key, $array)) ? $array[$key] : $default;
        }

        return $default;
    }
}