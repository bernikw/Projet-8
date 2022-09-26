<?php

namespace App\Tests;

trait LoginAccess
{
    public function loginAdmin ()
    {
        $crawler = $this->client->request();
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'email' => 'admin@gmail.com',
            'password' => 'Password'
        ]);
    }

    public function loginUser()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, [
            'email' => 'user@gmail.com',
            'password' => 'Password2'
        ]);

    }


}