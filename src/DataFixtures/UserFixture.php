<?php

namespace App\DataFixtures;

use App\Entity\User\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(3, 'main_users', function ($i){
            $user = new User();

            $firstName = $this->faker->firstName;
            $lastName = $this->faker->lastName;
            $user->setEmail(strtolower($firstName).".".strtolower($lastName)."@faker.com");
            $user->setName($firstName." ".$lastName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'test'
            ));
            return $user;
        });

        $manager->flush();
    }
}
