<?php

namespace Support\Helpers;

use Support\Util\Config;

if (!function_exists('t2pGetConfig')) {
    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    function t2pGetConfig($key, $default = '')
    {
        return (new Config())->get($key, $default);
    }
}

if (!function_exists('t2pGetAllConfig')) {
    /**
     * @param string $project
     * @return array
     */
    function t2pGetAllConfig($project = '')
    {
        return (new Config())->getAll($project);
    }
}


if (!function_exists('getEnvName')) {
    /**
     * @return mixed
     */
    function getEnvName()
    {
        return \T2P\Util\CommonConfig\Config::getEnvName();
    }
}

if (!function_exists('getEncryptKey')) {
    /**
     * @return string
     */
    function getEncryptKey()
    {
        return getEnvName() == 'PRODUCTION'
            ? config('support.key.pro')
            : config('support.key.dev');
    }
}

if (!function_exists('readConfig')) {
    /**
     * @param  $key
     * @param  string $default
     * @return mixed|string
     */
    function readConfig($key, $default = '')
    {
        return \Support\Util\Config(config("support.config"))
            ->get($key, $default);
    }
}


