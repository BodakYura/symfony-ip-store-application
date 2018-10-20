<?php

namespace Tests\Validator;

use bodakyuriy\IPStorageBundle\Validator\Validator;
use PHPUnit\Framework\Constraint\IsType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ValidatorTest extends KernelTestCase
{
    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = static::$kernel
            ->getContainer()
            ->get(Validator::class);
    }

    public function testValidValidateIPv4()
    {
        $result = $this->validator->validate('143.124.63.12');

        $this->assertInternalType(IsType::TYPE_ARRAY, $result);
        $this->assertEquals( 0, count($result));
    }


    public function testInValidValidateIPv4()
    {
        $result = $this->validator->validate('143.124.63.2222');

        $this->assertInternalType(IsType::TYPE_ARRAY, $result);
        $this->assertNotEquals(0, count($result));
    }

    public function testValidValidateIPv6()
    {
        $result = $this->validator->validate('fe80:1:2:3:a:bad:1dea:dad');

        $this->assertInternalType(IsType::TYPE_ARRAY, $result);
        $this->assertEquals( 0, count($result));
    }


    public function testInValidValidateIPv6()
    {
        $result = $this->validator->validate('fe8000:1:2:3:a:bad:1dea:dad');

        $this->assertInternalType(IsType::TYPE_ARRAY, $result);
        $this->assertNotEquals(0, count($result));
    }

}