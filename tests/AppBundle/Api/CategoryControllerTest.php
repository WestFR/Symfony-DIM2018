<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerApiTest extends WebTestCase
{
    public function testListCategoriesAction()
    {
        $crawler = $this->client->request('GET', '/api/categories');
        
        $this->client->request(
            'GET',
            'api/categories',
            array(),
            array(),
            array(
                'CONTENT_TYPE'  => 'application/json',
                'HTTP_X-USERNAME'    => 'steven.francony@somfy.com',
                'HTTP_X-PASSWORD'    => 'ok',
            )
        );

        $excepted = '[{"id":2,"name":"Comedy"},{"id":1,"name":"Drama"}]';

    }

    public function setUp() {
    	$this->client = static::createClient();
    }

    public function tearDown() {
    	$this->client = null;
    }
}
