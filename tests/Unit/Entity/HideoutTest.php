<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Country;
use App\Entity\Hideout;
use App\Entity\Mission;
use PHPUnit\Framework\TestCase;

class HideoutTest extends TestCase
{
    public function testIsTrue(): void
    {
        $country = new Country();
        $mission = new Mission();

        $hideout = (new Hideout())
            ->setCode('true code')
            ->setAddress('true address')
            ->setCountry($country)
            ->setMission($mission);

        $this->assertTrue($hideout->getcode() === 'true code');
        $this->assertTrue($hideout->getAddress() === 'true address');
        $this->assertTrue($hideout->getCountry() === $country);
        $this->assertTrue($hideout->getMission() === $mission);
    }

    public function testIsFalse(): void
    {
        $country = new Country();
        $mission = new Mission();

        $hideout = (new Hideout())
            ->setCode('true code')
            ->setAddress('true address')
            ->setCountry($country)
            ->setMission($mission);

        $this->assertFalse($hideout->getcode() === 'code');
        $this->assertFalse($hideout->getAddress() === 'address');
        $this->assertFalse($hideout->getCountry() === 'false');
        $this->assertFalse($hideout->getMission() === 'false');
    }
}
