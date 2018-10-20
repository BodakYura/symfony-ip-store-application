<?php

namespace bodakyuriy\IPStorageBundle\Service;

use bodakyuriy\IPStorageBundle\DriverChain;
use bodakyuriy\IPStorageBundle\ValidatorChain;

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
     * @var ValidatorChain
     */
    private $validatorChain;

    /**
     * @var string
     */
    private $validator;

    /**
     * @var string
     */
    private $driver;


    /**
     * IPStorageService constructor.
     * @param DriverChain $driverChain
     * @param ValidatorChain $validatorChain
     * @param string $storageDriver
     * @param string $validator
     */
    public function __construct(DriverChain $driverChain, ValidatorChain $validatorChain, string $storageDriver, string $validator)
    {
        $this->driverChain = $driverChain;
        $this->validatorChain = $validatorChain;
        $this->validator = $this->validatorChain->getValidator($validator);
        $this->driver = $this->driverChain->getDriver($storageDriver);
    }

    /**
     * @param string $ip
     * @return array
     */
    public function add(string $ip): array
    {
        $errors = $this->validator->validate($ip);

        switch (true) {
            case count($errors) > 0:
                return ['errors' => $errors];
                break;
            case $this->driver->save($ip):
                return ['count' => $this->driver->getCount($ip)];
                break;
            default:
                return ['errors' => ['Something went wrong']];
        }
    }

    /**
     * @param string $ip
     * @return array
     */
    public function getCount(string $ip): array
    {
        $errors = $this->validator->validate($ip);

        if (count($errors) > 0) {
            return ['errors' => $errors];
        }

        $result = $this->driver->getCount($ip);

        return ['count' => $result];
    }
}