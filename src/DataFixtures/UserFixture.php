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
            $user->setEmail(sprintf('spacebar%d@example.com', $i));
            $user->setName($this->faker->name);
            $user->setPassword($this->faker->password);
            return $user;
        });

        $manager->flush();
    }
}
