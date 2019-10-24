<?php

namespace Support\Contract;

/**
 * Interface ConfigInterface
 * @package ReadConfig\Contract
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
interface ConfigInterface
{
    /**
     * @param $key
     * @param string $default
     * @return mixed
     */
    public function get($key, $default = '');

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * @param string $project
     * @return mixed
     */
    public function getAll($project = '');

}