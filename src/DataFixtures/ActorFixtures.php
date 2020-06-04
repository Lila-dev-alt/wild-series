<?php


namespace App\DataFixtures;


use App\Entity\Actor;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
class ActorFixtures extends Fixture implements DependentFixtureInterface

{
    const ACTORS = [
        'Andrew Lincoln',
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira'
    ];

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
        $slugify = new Slugify();
        foreach (self::ACTORS as $key=> $actorName) {
            $actor = new Actor;
            $actor->setName($actorName);
            $actor->setSlug($slugify->generate($actor->getName()));
            $actor->addProgram($this->getReference('walking_dead'));
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }


        $faker = Faker\Factory::create('en_US');
        $slugify = new Slugify();
        for ($i = 4; $i < 55; $i ++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->setSlug($slugify->generate($actor->getName()));
            $actor->addProgram($this->getReference(self::PROGRAMS_REFERENCES[rand(0, 5)]));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
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
