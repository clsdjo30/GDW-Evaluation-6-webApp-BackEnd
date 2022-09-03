<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    /**
     * @
     * see \Doctrine\DBAL\Driver\Middleware
     */
    public function testShouldDisplayHomepage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Korp Général Business');
        $this->assertSelectorTextContains('p', 'Renseigner, Infiltrer, Excécuter');
    }
}
