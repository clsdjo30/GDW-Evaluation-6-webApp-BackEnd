<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{

    public function testFindAll(): void
    {

        $userRepository = new UserRepository();

        $userRepository->add($newUser = new User());


    }
}
