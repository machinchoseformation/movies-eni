<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    //un numéro de page par défaut est défini dans le routing.yml
    public function homeAction($page = 1)
    {
        //pour récupérer nos films depuis la bdd
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");

        //pour la pagination
        $numPerPage = 50; //le nombre de films affichés par page
        $offset = ($page-1) * $numPerPage; //le numéro du 1er film à récupérer
        $totalMoviesNum = $repo->countAll(); //nb total de films en bdd
        $totalPagesNum = ceil($totalMoviesNum / $numPerPage); //nb total de pages

        //nos films. La variable offset est responsable de l'effet de pagination
        $movies = $repo->findBy([], ["dateCreated" => "DESC"], $numPerPage, $offset);

        //si on va trop loin dans les # de pages...
        if (empty($movies)){
            throw $this->createNotFoundException("No movies here!");
        }

        //on passe plein de variables a twig pour se faciliter la vie
        return $this->render('AppBundle:Movie:home.html.twig', [
            "movies" => $movies,
            "page" => $page,
            "numPerPage" => $numPerPage,
            "totalPagesNum" => $totalPagesNum,
            "totalMoviesNum" => $totalMoviesNum
        ]);
    }

    //page de détails d'un film
    //on utilise les paramètres magiques ici pour récupérer le film automatiquement
    //en bdd
    public function detailsAction(Movie $movie, Request $request)
    {
        //on affiche et on traite le formulaire de critiques sur cette page
        //on crée une instance vide
        $review = new Review();
        //on l'associe au film
        $review->setMovie($movie);
        //on associe notre review au formulaire
        $reviewForm = $this->createForm(ReviewType::class, $review);
        //on récupère les données soumises du form
        $reviewForm->handleRequest($request);

        //si le formulaire est effectivement soumis...
        if ($reviewForm->isSubmitted() && $reviewForm->isValid()){
            //on sauvegarde l'entité en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            //message à afficher sur la prochaine page
            $this->addFlash("success", "Your review has been saved!");
            //on redirige ici-même !
            return $this->redirectToRoute('details', ['id' => $movie->getId()]);
        }

        //on affiche le twig en lui passant à la fois le film et le form de critique
        return $this->render('AppBundle:Movie:details.html.twig', [
            "movie" => $movie,
            "reviewForm" => $reviewForm->createView()
        ]);
    }
}
