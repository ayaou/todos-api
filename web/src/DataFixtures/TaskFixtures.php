<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; ++$i) {
            $task = new Task();
            $task->setTitle($faker->text(50));
            $task->setDescription($faker->text(250));
            $task->setDay($faker->dateTimeBetween('-1 day', '+1 day'));
            $task->setDone($faker->boolean());

            $manager->persist($task);
        }

        $manager->flush();
    }
}
