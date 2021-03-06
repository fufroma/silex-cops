<?php

namespace Cops\Tests\Controller;

use Silex\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function createApplication()
    {
        return require __DIR__.'/../application.php';
    }

    public function testHomepageResponseCode()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/fr/');

        $this->assertTrue($client->getResponse()->isOk());

        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
    }

}
