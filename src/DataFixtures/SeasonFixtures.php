<?php


namespace App\DataFixtures;


use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS_REFERENCES = [
        'walking_dead',
        'the_haunting_of_hill_house',
        'american_horror_story',
        'love_death_and_robots',
        'penny_dreadful',
        'fear_the_walking_dead',
    ];


    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 30; $i++) {
            $season = new Season();
            $season->setProgram($this->getReference(self::PROGRAMS_REFERENCES [rand(0, 5)]));
            $season->setNumber(rand(1, 10));
            $season->setYear(rand(2010, 2020));
            $season->setDescription($faker->paragraph);
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
        }
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
