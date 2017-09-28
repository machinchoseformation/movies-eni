<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    public function homeAction($page = 1)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");

        //pour la pagination
        $numPerPage = 50;
        $offset = ($page-1) * $numPerPage;
        $totalMoviesNum = $repo->countAll();
        $totalPagesNum = ceil($totalMoviesNum / $numPerPage);

        $movies = $repo->findBy([], ["dateCreated" => "DESC"], $numPerPage, $offset);

        if (empty($movies)){
            throw $this->createNotFoundException("No movies here!");
        }

        return $this->render('AppBundle:Movie:home.html.twig', [
            "movies" => $movies,
            "page" => $page,
            "numPerPage" => $numPerPage,
            "totalPagesNum" => $totalPagesNum,
            "totalMoviesNum" => $totalMoviesNum
        ]);
    }

    public function detailsAction(Movie $movie, Request $request)
    {
        //on affiche et on traite le formulaire de critiques
        $review = new Review();
        $review->setMovie($movie);
        $reviewForm = $this->createForm(ReviewType::class, $review);
        $reviewForm->handleRequest($request);

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            $this->addFlash("success", "Your review has been saved!");
            return $this->redirectToRoute('details', ['id' => $movie->getId()]);
        }

        return $this->render('AppBundle:Movie:details.html.twig', [
            "movie" => $movie,
            "reviewForm" => $reviewForm->createView()
        ]);
    }
}
