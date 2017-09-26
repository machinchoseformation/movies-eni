<?php

namespace AppBundle\Controller;

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

    public function detailsAction($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $repo->find($id);

        return $this->render('AppBundle:Movie:details.html.twig', [
            "movie" => $movie
        ]);
    }
}
