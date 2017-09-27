<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminReviewController extends Controller
{
    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Review");
        $reviews = $repo->findBy([], ["id" => "DESC"]);

        return $this->render('AppBundle:AdminReview:list.html.twig', [
            "reviews" => $reviews
        ]);
    }

    public function deleteAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Review");
        $review = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($review);
        $em->flush();

        $this->addFlash("success", "The review was successfully deleted!");
        return $this->redirectToRoute("admin_reviews");
    }

    public function editAction($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository("AppBundle:Review");
        $review = $repo->find($id);

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            $this->addFlash("success", "The review was successfully edited!");
            return $this->redirectToRoute("admin_reviews");
        }

        return $this->render("AppBundle:AdminReview:edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

}
