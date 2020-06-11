<?php


namespace App\DataFixtures;


use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Proxies\__CG__\App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Service\Slugify;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
   const PROGRAMS = [
       'Walking Dead' => [


           'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',

           'poster' => 'https://m.media-amazon.com/images/M/MV5BZmFlMTA0MmUtNWVmOC00ZmE1LWFmMDYtZTJhYjJhNGVjYTU5XkEyXkFqcGdeQXVyMTAzMDM4MjM0._V1_.jpg',
           'category' => 'categorie_4',
           'country'=> 'Etats-Unis',
           'year'=> 2010,

           'reference' => 'walking_dead',


       ],


       'The Haunting Of Hill House' => [


           'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
           'poster'=> 'https://m.media-amazon.com/images/M/MV5BMTU4NzA4MDEwNF5BMl5BanBnXkFtZTgwMTQxODYzNjM@._V1_SY1000_CR0,0,674,1000_AL_.jpg',

           'category' => 'categorie_4',
           'country'=> 'Etats-Unis',
           'year'=> 2018,

           'reference' => 'the_haunting_of_hill_house',
       ],


       'American Horror Story' => [


           'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',

           'poster' => 'https://m.media-amazon.com/images/M/MV5BODZlYzc2ODYtYmQyZS00ZTM4LTk4ZDQtMTMyZDdhMDgzZTU0XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1_SY1000_CR0,0,666,1000_AL_.jpg',
           'category' => 'categorie_4',
           'country'=> 'Etats-Unis',
           'year'=> 2011,

           'reference' => 'american_horror_story',
       ],


       'Love Death And Robots' => [


           'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',
           'poster' => 'https://m.media-amazon.com/images/M/MV5BMTc1MjIyNDI3Nl5BMl5BanBnXkFtZTgwMjQ1OTI0NzM@._V1_SY1000_CR0,0,674,1000_AL_.jpg',

           'category' => 'categorie_4',
           'country'=> 'Etats-Unis',
           'year'=> 2019,

           'reference' => 'love_death_and_robots',


       ],


       'Penny Dreadful' => [


           'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',

           'poster' => 'https://m.media-amazon.com/images/M/MV5BNmE5MDE0ZmMtY2I5Mi00Y2RjLWJlYjMtODkxODQ5OWY1ODdkXkEyXkFqcGdeQXVyNjU2NjA5NjM@._V1_SY1000_CR0,0,695,1000_AL_.jpg',
           'category' => 'categorie_4',
           'country'=> 'Etats-Unis',
           'year'=> 2014,
           'reference' => 'penny_dreadful',

       ],


       'Fear The Walking Dead' => [


           'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',

           'poster' => 'https://m.media-amazon.com/images/M/MV5BYWNmY2Y1NTgtYTExMS00NGUxLWIxYWQtMjU4MjNkZjZlZjQ3XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1_SY1000_CR0,0,666,1000_AL_.jpg',
           'category' => 'categorie_4',
           'country'=> 'Etats-Unis',
           'year'=> 2015,

           'reference' => 'fear_the_walking_dead',
       ],

   ];

   /**
    * @inheritDoc
    */

    public function load(ObjectManager $manager)
    {
        $i = 0;
        $slugify = new Slugify();
        foreach (self::PROGRAMS as $title=> $data) {
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setPoster($data['poster']);
            $program->setSlug($slugify->generate($program->getTitle()));
            $program->setCategory($this->getReference($data['category']));
            $program->setCountry($data['country']);
            $program->setYear($data['year']);
            $manager->persist($program);
            $this->addReference($data['reference'], $program);
            $i++;


        }
        $faker = Faker\Factory::create('en_US');
        $slugify = new Slugify();
        for ($i=10; $i<12; $i++) {
            $program = new Program();
            $title = $faker->sentence(3);
            $program->setTitle($title);
            $program->setSummary($faker->paragraph);
            $program->setPoster($faker->imageUrl());
            $program->setCountry($faker->country);
            $program->setYear(rand(2009, 2020));
            $program->setSlug($slugify->generate($program->getTitle()));
            $program->setCategory($this->getReference('categorie_' . rand(0, 4)));
            $manager->persist($program);
            $this->addReference('program_' . $i, $program);
        $manager->flush();
    }


}

    /**
     * @inheritDoc
     */

public function getDependencies()
    {

        return [CategoryFixtures::class];
    }
    }

