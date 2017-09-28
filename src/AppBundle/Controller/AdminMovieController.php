<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use AppBundle\Form\MovieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminMovieController extends Controller
{
    //liste de tous les films
    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        //récupère tous les films
        $movies = $repo->findBy([], ["dateCreated" => "DESC"]);

        return $this->render('AppBundle:AdminMovie:list.html.twig', [
            "movies" => $movies
        ]);
    }

    //efface un film en fct de son id
    public function deleteAction($id)
    {
        //on récupère d'abord le film depuis la bdd
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $repo->find($id);

        //on utilise le manager pour la suppression
        $em = $this->getDoctrine()->getManager();
        //on supprime d'abord manuellement toutes les reviews associées à ce film
        //voir les relations définies dans les entités
        //on aurait pu aussi utiliser les opérations de cascade
        foreach($movie->getReviews() as $review){
            $em->remove($review);
        }

        //on supprime finalement le film
        $em->remove($movie);
        //on exécute
        $em->flush();

        //pas de twig à afficher ici, on dégage ailleurs
        $this->addFlash("success", "The movie was successfully deleted!");
        return $this->redirectToRoute("admin_home");
    }

    //modifie un film en fct de son id
    public function editAction($id, Request $request)
    {
        //on récupère le film en bdd
        $repo = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $repo->find($id);

        //on crée le form en lui associant le film récupéré
        $form = $this->createForm(MovieType::class, $movie);
        //on récupère les données soumises
        $form->handleRequest($request);

        //si le form est soumis...
        if ($form->isSubmitted() && $form->isValid()){
            //on sauvegarde le film
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            //on redirige avec un message
            $this->addFlash("success", "The movie was successfully edited!");
            return $this->redirectToRoute("admin_home");
        }

        //on affiche la page de modification en lui passant le formulaire
        return $this->render("AppBundle:AdminMovie:edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    //crée un nouveau film
    public function addAction(Request $request)
    {
        //ici on crée une entité toute fraîche
        $movie = new Movie();
        //on renseigne les valeurs qui ne sont pas dans le formulaire
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
