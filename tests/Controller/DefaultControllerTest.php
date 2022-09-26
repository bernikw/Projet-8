<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function test(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $button = $crawler->selectLink('Créer un utilisateur');
       
        $this->assertEquals(1, count($button));
        
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }
}
