<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Mission;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = (new User())
            ->setEmail('true@email.com')
            ->setPassword('truepassword')
            ->setRoles(['ROLE_TEST']);
        $identifier = $user->getEmail();


        $this->assertTrue($user->getUserIdentifier() === $identifier);
        $this->assertTrue($user->getEmail() === 'true@email.com');
        $this->assertTrue($user->getPassword() === 'truepassword');
        $this->assertTrue($user->getRoles() === ['ROLE_TEST', 'ROLE_USER']);

    }

    public function testIsFalse(): void
    {
        $user = (new User())
            ->setEmail('true@email.com')
            ->setPassword('truepassword')
            ->setRoles(['ROLE_TEST']);

        $this->assertFalse($user->getEmail() === 'false@email.com');
        $this->assertFalse($user->getPassword() === 'falsepassword');
        $this->assertFalse($user->getRoles() === ['ROLE_USER']);

    }

    public function testAddGetRemoveMission(): void
    {
        $user = new User();
        $mission = new Mission();

        $this->assertEmpty($user->getMissions());

        $user->addMission($mission);
        $this->assertContains($mission, $user->getMissions());

        $user->removeMission($mission);
        $this->assertEmpty($user->getMissions());


    }


}
