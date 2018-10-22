<?php

namespace bodakyuriy\IPStorageBundle;

use bodakyuriy\IPStorageBundle\Validator\Contract\ValidatorInterface;

/**
 * Class ValidatorChain
 * @package bodakyuriy\IPStorageBundle
 */
class ValidatorChain
{
    /**
     * @var array
     */
    private $validators;

    /**
     * ValidatorChain constructor.
     */
    public function __construct()
    {
        $this->validators = [];
    }

    /**
     * @param ValidatorInterface $validator
     * @param string $alias
     */
    public function addValidator(ValidatorInterface $validator, string $alias)
    {
        $this->validators[$alias] = $validator;
    }

    /**
     * @param string $validator
     * @return ValidatorInterface
     */
    public function getValidator(string $validator): ValidatorInterface
    {
        return $this->validators[$validator];
    }
}