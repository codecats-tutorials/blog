<?php

namespace Blogger\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testIndex() 
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($crawler->filter('article.blog')->count() > 0);
        
        $blogLink = $crawler->filter('article.blog h2 a')->first();
        $blogTitle = $blogLink->text();

        $crawler = $client->click($blogLink->link());
        
        $this->assertEquals(1, $crawler->filter('h2:contains("' . $blogTitle . '")')->count());
    }
    public function testAbout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/about');
        
        $this->assertEquals(1, $crawler->filter('h1:contains("About blog")')->count());
    }

}
