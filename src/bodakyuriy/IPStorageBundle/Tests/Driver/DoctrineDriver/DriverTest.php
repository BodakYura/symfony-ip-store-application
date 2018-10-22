<?php

namespace Tests\Driver\DoctrineDriver;

use bodakyuriy\IPStorageBundle\Driver\DoctrineDriver\Driver;
use PHPUnit\Framework\Constraint\IsType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IPStorageServiceTest extends KernelTestCase
{
    private $driver;

    protected function setUp()
    {
        self::bootKernel();
        $this->driver = static::$kernel
            ->getContainer()
            ->get(Driver::class);
    }

    public function testSave()
    {
        $result = $this->driver->save('143.124.63.12');

        $this->assertInternalType(IsType::TYPE_BOOL, $result);
    }


    public function testGetCount()
    {
        $result = $this->driver->getCount('143.124.63.12');

        $this->assertInternalType(IsType::TYPE_INT, $result);
    }

}