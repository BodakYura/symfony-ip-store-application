<?php

namespace bodakyuriy\IPStorageBundle\Service\Contract;

/**
 * Interface IPStorageServiceInterface
 * @package bodakyuriy\IPStorageBundle\Service\Contract
 */
interface IPStorageServiceInterface
{
    /**
     * @param string $ip
     * @return array
     */
    public function add(string $ip): array ;

    /**
     * @param string $ip
     * @return array
     */
    public function getCount(string $ip): array ;
}