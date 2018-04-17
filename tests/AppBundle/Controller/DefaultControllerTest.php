<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertContains('Login', $crawler->filter('h1')->text());

		$crawler = $this->client->back();
		$this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function setUp() {
    	$this->client = static::createClient();
    }

    public function tearDown() {
    	$this->client = null;
    }
}
