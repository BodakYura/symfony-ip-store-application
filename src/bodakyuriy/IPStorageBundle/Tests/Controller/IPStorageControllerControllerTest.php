<?php

namespace bodakyuriy\IPStorageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IPStorageControllerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/ip-storage');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdd()
    {
        $client = static::createClient();
        $client->request('GET', '/ip-storage/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddPost()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ip-storage/add');
        $client->getResponse()->getContent();

        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('ip_form_token');

        $form = $crawler->filter('.ip-form')->form();
        $form['ip'] = '192.168.1.33';
        $form['_token'] = $csrfToken;
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testQuery()
    {
        $client = static::createClient();
        $client->request('GET', '/ip-storage/query');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testQueryPost()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ip-storage/query');
        $client->getResponse()->getContent();

        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('ip_form_token');

        $form = $crawler->filter('.ip-form')->form();
        $form['ip'] = '192.168.1.33';
        $form['_token'] = $csrfToken;
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
