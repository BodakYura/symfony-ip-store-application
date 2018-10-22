<?php

namespace bodakyuriy\IPStorageBundle;

use bodakyuriy\IPStorageBundle\Driver\Contract\StorageDriverInterface;

/**
 * Class DriverChain
 * @package bodakyuriy\IPStorageBundle
 */
class DriverChain
{
    /**
     * @var array
     */
    private $drivers;

    /**
     * DriverChain constructor.
     */
    public function __construct()
    {
        $this->drivers = [];
    }

    /**
     * @param StorageDriverInterface $driver
     * @param string $alias
     */
    public function addDriver(StorageDriverInterface $driver, string $alias)
    {
        $this->drivers[$alias] = $driver;
    }

    /**
     * @param string $driver
     * @return StorageDriverInterface
     */
    public function getDriver(string $driver): StorageDriverInterface
    {
        return $this->drivers[$driver];
    }
}