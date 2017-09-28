<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Review;
use NantesBundle\Entity\Category;
use NantesBundle\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use NantesBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Fixtures extends Fixture implements ContainerAwareInterface
{
    //on ajoute ça pour avoir accès au container
    protected $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    //cette fonction sera appelée lorsqu'on exécutera :
    //php bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager)
    {
        $filename = __DIR__ . "/sf_movies_eni_09_22_17.sql";
        $sql = file_get_contents($filename);  // Read file contents
        $manager->getConnection()->exec($sql);
        $manager->flush();

        //on a besoin de faker pour générer des données bidons
        $faker = \Faker\Factory::create("fr_FR");

        //on récupère tous les films pour leur donner des reviews
        $movieRepo = $manager->getRepository("AppBundle:Movie");
        $allMovies = $movieRepo->findAll();

        foreach($allMovies as $movie){

            //ce film aura un nombre aléatoire de review
            $reviewsNumber = mt_rand(0,15);
            for($i=0; $i<$reviewsNumber; $i++){
                //on crée le nombre de review décidé ci-dessus
                $review = new Review();
                $review->setUsername($faker->userName);
                $review->setTitle($faker->sentence);
                $review->setContent($faker->text);
                $review->setRating($faker->numberBetween(0,10));
                //on les associe au film
                $review->setMovie($movie);
                //on sauvegarde
                $manager->persist($review);
            }

        }

        //en flushant, on exécute réellement les requêtes sql
        $manager->flush();
    }
}