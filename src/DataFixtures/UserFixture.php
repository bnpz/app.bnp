<?php

namespace App\DataFixtures;

use App\Entity\User\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(3, 'main_users', function ($i){
            $user = new User();

            $firstName = $this->faker->firstName;
            $lastName = $this->faker->lastName;
            $user->setEmail(strtolower($firstName).".".strtolower($lastName)."@faker.com");
            $user->setName($firstName." ".$lastName);
            $user->setPassword($this->faker->password);
            return $user;
        });

        $manager->flush();
    }
}
