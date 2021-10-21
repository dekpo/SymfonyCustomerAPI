<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i=0;$i<100;$i++){
        $customer = new Customer();
        $customer->setFirstName($faker->firstName());
        $customer->setLastName($faker->lastName());
        $customer->setEmail($faker->email());
        $customer->setPhoneNumber($faker->phoneNumber());
        $manager->persist($customer);
        }

        $manager->flush();
    }
}
