<?php

namespace bodakyuriy\IPStorageBundle\Validator;

use bodakyuriy\IPStorageBundle\Contracts\ValidatorInterface;

class Validator implements ValidatorInterface
{
    private $errors = [];

    public function validate(string $ip): array
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP) && !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->errors[] = "$ip is not valid IP address";
        }

        return $this->errors;
    }

}