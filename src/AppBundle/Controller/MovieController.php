<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    public function homeAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movies = $repo->findBy([], ["dateCreated" => "DESC"], 50, 0);

        return $this->render('AppBundle:Movie:home.html.twig', [
            "movies" => $movies
        ]);
    }

    public function detailsAction(Movie $movie, Request $request)
    {
        return $this->render('AppBundle:Movie:details.html.twig', [
            "movie" => $movie
        ]);
    }
}
