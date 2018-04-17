<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testCreateCategorySuccess()
    {
        $client = static::createClient();
        $this->login($client);
        
        $crawler = $client->request('GET', '/category/create');
        $this->assertContains('Create a new category', $crawler->filter('h1')->text());
        
        $name = time();
        
        $form = $crawler->selectButton('Save')->form();
        $crawler = $client->submit(
            $form,
            ['category[name]' => $name]
        );

        $crawler = $client->followRedirect();
        $this->assertContains('You successfully added a new category !', $crawler->filter('html')->text());
        
        $link = $crawler->selectLink('Create category')->link();
        
        $crawler = $client->click($link);
        $this->assertContains('Create a new category', $crawler->filter('h1')->text());
    }

    /**
     * Logs in the user
     *
     * @param Symfony\Component\BrowserKit\Client $client
     *
     * @return Symfony\Component\DomCrawler $crawler
     */
    private function login($client)
    {
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->selectButton('Connect')->form();
        $crawler = $client->submit(
            $form,
            [
                'email' => 'rho@email.com',
                'password' => 'test'
            ]
        );

        return $client->followRedirect();
    }
}
