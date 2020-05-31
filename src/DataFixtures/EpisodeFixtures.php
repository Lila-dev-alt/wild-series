<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 300; $i++) {
            $episode = new Episode();
            $episode->setSeason($this->getReference('season_' . rand(0,29)));
            $episode->setTitle($faker->sentence(3));
            $episode->setNumber(rand(1,10));
            $episode->setSynopsis($faker->paragraph);
            $manager->persist($episode);

         }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
