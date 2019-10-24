<?php

namespace Support\Util;

use Support\Contract\ConfigInterface;

/**
 * Class Config
 * @package ReadConfig\Util
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
class Config implements ConfigInterface
{
    /**
     * @var
     */
    private $path;

    /**
     * @var
     */
    private $key;

    /**
     * @var
     */
    private $project;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->key     = isset($config['key']) ? $config['key'] : null;
        $this->path    = isset($config['path']) ? $config['path'] : '/data/_inc';
        $this->project = isset($config['project']) ? $config['project'] : '/';
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }


    /**
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public function get($key, $default = '')
    {
        return isset($this->read()[$key])
            ? $this->read()[$key]
            : $default;
    }

    /**
     * @param $key
     * @param $value
     * @return bool|int
     */
    public function set($key, $value)
    {
        $data       = $this->read();
        $data[$key] = $this->encrypt($value);
        return $this->write($data);
    }

    /**
     * @param array $data
     * @return bool|int
     */
    public function setAll($data = [])
    {
        foreach ($data as $key => $value) {
            $data[$key] = $this->encrypt($value);
        }
        return $this->write($data);
    }

    /**
     * @param $project
     * @return array
     */
    public function getAll($project = '')
    {
        if (!empty($project)) {
            $this->setProject($project);
        }
        return $this->read();
    }

    /**
     * @param array $data
     * @return bool|int
     */
    private function write($data = [])
    {
        $fullPath = $this->getFilePath();
        return file_put_contents($fullPath, json_encode($data));
    }

    /**
     * @return array
     */
    private function read()
    {
        $fullPath = $this->getFilePath();
        if (is_file($fullPath)) {
            $result  = [];
            $content = json_decode(file_get_contents($fullPath), true);
            foreach ($content as $key => $value) {
                $result[$key] = $this->decrypt($value);
            }
            return $result;
        }
        return [];
    }

    /**
     * @return string
     */
    private function getFilePath()
    {
        return $this->path . '/'
            . $this->project;
    }

    /**
     * @param $encrypted
     * @return string
     */
    private function decrypt($encrypted)
    {
        $parts = explode(':', $encrypted);
        $key   = base64_decode($this->key);
        return openssl_decrypt($parts[0],
            'aes-256-cbc',
            $key, 0, base64_decode($parts[1])
        );
    }

    /**
     * @param $raw
     * @return string
     */
    private function encrypt($raw)
    {
        $key       = base64_decode($this->key);
        $iv        = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($raw,
            'aes-256-cbc',
            $key, 0, $iv
        );
        return $encrypted . ':' . base64_encode($iv);
    }
}