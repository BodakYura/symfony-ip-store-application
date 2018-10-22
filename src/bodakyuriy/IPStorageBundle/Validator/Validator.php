<?php

namespace bodakyuriy\IPStorageBundle\Validator;

use bodakyuriy\IPStorageBundle\Validator\Contract\ValidatorInterface;

/**
 * Class Validator
 * @package bodakyuriy\IPStorageBundle\Validator
 */
class Validator implements ValidatorInterface
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param string $ip
     * @return array
     */
    public function validate(string $ip): array
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP) && !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->errors[] = "$ip is not valid IP address";
        }

        return $this->errors;
    }

}