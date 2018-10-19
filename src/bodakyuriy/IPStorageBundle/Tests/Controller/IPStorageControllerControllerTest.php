<?php

namespace bodakyuriy\IPStorageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IPStorageControllerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ip-storage');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ip-storage/add');
    }

}
