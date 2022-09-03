<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MissionTest extends WebTestCase
{
    public function testShouldDisplayMission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/mission');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Les Dernieres Mission');
    }

    public function testShouldDisplayMissionTest(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/mission/mission-test');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mission de test');
    }

}
