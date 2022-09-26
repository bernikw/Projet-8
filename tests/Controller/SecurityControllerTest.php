<?php

namespace App\Tests\Controller;


use App\Tests\LoginAccess;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    use LoginAccess;

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /*public function testLoginPage(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $button = $crawler->selectLink('Se connecter');

        $this->assertEquals(1, count($button));
    }*/

    public function testLoginSuccess(): void
    {

        $crawler = $this->client->request('GET', '/login');
        

        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'email' => 'admin@gmail.com',
            'password' => 'Password'
        ]);

        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Se déconnecter', $this->client->getResponse()->getContent());
        
    }

    public function testLoginBadCredentials(): void
    {

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'email' => 'fake@gmail.com',
            'password' => 'fakepass'
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();
        $this->assertSelectorTextContains("div.alert-danger", "Invalid credentials.");
    }

    public function testLogout(): void
    {

        $this->loginUser();

        $crawler = $this->client->request('GET', '/logout');


        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


        $crawler->selectLink('Se déconnecter');
    }
}
