<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    public function testIsTrue(): void
    {
        $country = (new Country())
            ->setName('country')
            ->setNationality('nationality');

        $this->assertTrue($country->getName() === 'country');
        $this->assertTrue($country->getNationality() === 'nationality');
    }

    public function testIsFalse(): void
    {
        $country = (new Country())
            ->setName('country')
            ->setNationality('nationality');

        $this->assertFalse($country->getName() === 'false country');
        $this->assertFalse($country->getNationality() === 'flase nationality');
    }
}
