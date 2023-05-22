<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\ProjectMilestone;
use App\Entity\User;
use App\Enum\UserStatus;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->safeEmail())
                ->setEnabled($faker->boolean())
                ->setStatus($faker->randomElement([UserStatus::ACTIVE, UserStatus::INACTIVE, UserStatus::SUSPENDED]));

            for ($j = 0; $j < random_int(3, 10); $j++) {
                $project = new Project();
                $project
                    ->setProjectUser($user)
                    ->setTitle($faker->text(20))
                    ->setDescription($faker->text(20));

                $manager->persist($project);

                for ($k = 0; $k < random_int(3, 10); $k++) {
                    $projectMilestone = new ProjectMilestone();
                    $projectMilestone
                        ->setProject($project)
                        ->setTitle($faker->text(20))
                        ->setDescription($faker->text(20))
                        ->setDeadline(DateTimeImmutable::createFromMutable($faker->dateTime()));

                    $manager->persist($projectMilestone);
                }
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
