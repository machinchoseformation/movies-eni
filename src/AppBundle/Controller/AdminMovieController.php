<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminMovieController extends Controller
{
    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movies = $repo->findBy([], ["dateCreated" => "DESC"]);

        return $this->render('AppBundle:AdminMovie:list.html.twig', [
            "movies" => $movies
        ]);
    }

    public function deleteAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($movie);
        $em->flush();

        $this->addFlash("success", "The movie was successfully deleted!");
        return $this->redirectToRoute("admin_home");
    }
}
