<?php

use Support\Util\Config;

if (!function_exists('t2pGetConfig')) {
    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    function t2pGetConfig($key, $default = '')
    {
        return (new Config(getInitConfig()))->get($key, $default);
    }
}

if (!function_exists('t2pGetAllConfig')) {
    /**
     * @param string $project
     * @return array
     */
    function t2pGetAllConfig($project = '')
    {
        return (new Config(getInitConfig()))->getAll($project);
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

if (!function_exists('getInitConfig')) {
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    function getInitconfig()
    {
        $init = config("support.config");
        $init['key'] = getEncryptKey();
        return $init;
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
        return (new Config(getInitConfig()))
            ->get($key, $default);
    }
}


