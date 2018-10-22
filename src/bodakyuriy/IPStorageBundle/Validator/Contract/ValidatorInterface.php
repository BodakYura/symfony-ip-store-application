<?php

namespace bodakyuriy\IPStorageBundle\Validator\Contract;


/**
 * Interface ValidatorInterface
 * @package IPStorageBundle\Contracts
 */
interface ValidatorInterface
{
    /**
     * @param string $ip
     * @return array
     */
    public function validate(string $ip) : array;
}