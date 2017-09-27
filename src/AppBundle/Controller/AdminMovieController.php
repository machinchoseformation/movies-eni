<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use AppBundle\Form\MovieType;
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
        foreach($movie->getReviews() as $review){
            $em->remove($review);
        }

        $em->remove($movie);
        $em->flush();

        $this->addFlash("success", "The movie was successfully deleted!");
        return $this->redirectToRoute("admin_home");
    }

    public function editAction($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $repo->find($id);

        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            $this->addFlash("success", "The movie was successfully edited!");
            return $this->redirectToRoute("admin_home");
        }

        return $this->render("AppBundle:AdminMovie:edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    public function addAction(Request $request)
    {
        $movie = new Movie();
        $movie->setDateCreated(new \DateTime());
        $movie->setDateModified(new \DateTime());

        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            $this->addFlash("success", "The movie was successfully created!");
            return $this->redirectToRoute("admin_home");
        }

        return $this->render("AppBundle:AdminMovie:add.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
