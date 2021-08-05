<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use App\Entity\User;
use App\Entity\UserCollection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserCollectionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++){
            $userCollection = new UserCollection();

            // @todo : gérer la prise en compte des id en base, car à chaque load la table n'est pas truncate

            $userCollection
                ->setUser($manager->getRepository(User::class)->find(rand(420, 444)))
                //->setUser(rand(154, 174))
                ->setCollection($manager->getRepository(Collection::class)->find(rand(420, 444)))
                //->setCollection(rand(420, 444))
                ->setFavourite($faker->boolean)
                ->setComment($faker->text())
            ;
        }

        $manager->flush();
    }
}
