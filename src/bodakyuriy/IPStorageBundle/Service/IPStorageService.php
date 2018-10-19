<?php

namespace bodakyuriy\IPStorageBundle\Service;


use bodakyuriy\IPStorageBundle\DriverChain;
use bodakyuriy\IPStorageBundle\Contracts\StorageDriverInterface;

/**
 * Class IPStorageService
 * @package bodakyuriy\IPStorageBundle\Service
 */
class IPStorageService
{
    /**
     * @var DriverChain
     */
    private $driverChain;

    /**
     * @var string
     */
    private $driver;

    /**
     * IPStorageService constructor.
     * @param DriverChain $driverChain
     * @param string $storageDriver
     */
    public function __construct(DriverChain $driverChain, string $storageDriver)
    {
        $this->driverChain = $driverChain;
        $this->driver = $this->driverChain->getDriver($storageDriver);
    }

    /**
     * @param string $ip
     * @return array
     */
    public function add(string $ip): array
    {
        $result = $this->driver->save($ip);

        return ['count' => $result];
    }

    /**
     * @param string $ip
     * @return array
     */
    public function getCount(string $ip): array
    {
        $result = $this->driver->getCount($ip);

        return ['count' => $result];
    }
}