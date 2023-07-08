<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR') ;

        for ($i = 0; $i < 100; $i++){
            $client = new Client();
            $client->setUsername($faker->userName);
            $client->setEmail($faker->email); 
            $client->setPassword($faker->password()) ;

            $manager->persist($client); 
        }

        $manager->flush();
    }
}
