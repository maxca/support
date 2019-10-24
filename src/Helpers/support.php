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