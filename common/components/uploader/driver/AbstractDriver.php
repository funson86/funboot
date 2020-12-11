<?php

namespace common\components\uploader\driver;

use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;

/**
 * Class AbstractAdapter
 * @package common\components\uploader\driver
 * @author funson86 <funson86@gmail.com>
 */
abstract class AbstractDriver
{

    /**
     * @var
     */
    public $config;

    /**
     * @var AdapterInterface
     */
    public $adapter;

    /**
     * @var \League\Flysystem\Filesystem
     */
    public $filesystem;

    public function __construct($config = [])
    {
        $this->config = $config;
        $this->init();
    }

    abstract protected function init();

    abstract protected function getConfig();

    public function getFilesystem()
    {
        if (!$this->filesystem instanceof Filesystem) {
            $this->filesystem = new Filesystem($this->adapter);
        }

        return $this->filesystem;
    }

}