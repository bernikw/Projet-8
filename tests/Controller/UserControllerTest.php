<?php

namespace App\Tests\Controller;

use App\Tests\LoginAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

 

    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }


    public function testListUsers(): void
    {
      

        $this->client->request(Request::METHOD_GET, ('/users'));

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

      

    }
 /*
    public function testDeleteUser(): void
    {
        $this->loginAdmin();

        $crawler = $this->client->request(Request::METHOD_GET, ('/users/user4/delete'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div.alert-success', 'Le user a été supprimé avec succès !');

        $this->assertRouteSame('/users');

    }*/
}
