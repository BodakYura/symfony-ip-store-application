<?php

namespace Tests\IPStorageBundle\Service;


use bodakyuriy\IPStorageBundle\Service\IPStorageService;
use PHPUnit\Framework\Constraint\IsType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IPStorageServiceTest extends KernelTestCase
{
    private $storageService;

    protected function setUp()
    {
        self::bootKernel();
        $this->storageService = static::$kernel
            ->getContainer()
            ->get(IPStorageService::class);
    }

    public function testAdd()
    {
        $result = $this->storageService->add('143.124.63.12');

        $this->assertInternalType(IsType::TYPE_ARRAY, $result);
    }


    public function testGetCount()
    {
        $result = $this->storageService->getCount('143.124.63.12');

        $this->assertInternalType(IsType::TYPE_ARRAY, $result);
    }
}