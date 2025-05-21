<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/inscription');
        $client->submitForm('Valider', ['register_user_type_form[firstname]' => 'test',
                'register_user_type_form[lastname]' => 'test',
                'register_user_type_form[email]' => 'test' . time() . '@test.com',
                'register_user_type_form[plainPassword][first]' => 'test123',
                'register_user_type_form[plainPassword][second]' => 'test123'
            ]
        );
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("Votre compte a bien été crée, Connectez-vous !")');
    }
}
