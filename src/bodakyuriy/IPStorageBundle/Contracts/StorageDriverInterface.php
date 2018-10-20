<?php

namespace bodakyuriy\IPStorageBundle\Contracts;


/**
 * Interface StorageDriverInterface
 * @package IPStorageBundle\Contracts
 */
interface StorageDriverInterface
{
    /**
     * @param string $ip
     * @return int
     */
    public function save(string $ip) : bool;

    /**
     * @param string $ip
     * @return int
     */
    public function getCount(string $ip) : int;
}