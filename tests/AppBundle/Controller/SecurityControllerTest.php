<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertContains('Login', $crawler->filter('h1')->text());

        // FORM
        $form = $crawler->selectButton('Submit')->form();
        $crawler = $this->client->submit(
            $form,
            [
                'email' => 'steven.francony@somfy.com',
                'password' => 'ok'
            ] 
        );

        // REDIRECT LOGIN FORM
        $crawler = $this->client->followRedirect();
        $this->assertContains('My Shows list', $crawler->filter('h1')->text());
    }

    public function setUp() {
    	$this->client = static::createClient();
    }

    public function tearDown() {
    	$this->client = null;
    }
}
