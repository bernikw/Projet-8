<?php

namespace App\Tests\Controller;

use App\Tests\LoginAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{ 
    


    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

      public function testListTaskIsSuccessfull(): void
    {
    
        $this->loginAdmin();

        $this->client->request(Request::METHOD_GET, ('/tasks'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        

        $this->assertRouteSame('/tasks');



    }
   
    public function testTaskCreation(): void
    {
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        $client->loginUser($testUser);
       
        $crawler = $this->client->request(Request::METHOD_GET, ('/tasks/create'));

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]'=> "Task7",
            'task[content]' => "Task content"
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a été bien été ajoutée.');
        $this->assertRouteSame('/tasks');
    }

    public function testTaskEdit(): void
    {

        $crawler = $this->client->request(Request::METHOD_GET, ('/tasks/task2/edit'));

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]'=> "Task 9",
            'task[content]' => "Task edit"
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert-success', 'La tâche a bien été modifiée.');
        $this->assertRouteSame('/tasks');
    }*/

    public function testTaskDelete(): void
    {
        $this->loginUser();

        $crawler = $this->client->request(Request::METHOD_GET, ('/tasks/task5/delete'));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

    }

    public function testTaskAnonymousDelete(): void
    {
        
        $this->loginUser();
        $crawler = $this->client->request(Request::METHOD_GET, ('/tasks/task1/delete'));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
   

    }
}
