<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\GetCategorieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, GetCategorieService $getCategorieService)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setFirstname($form->get('firstname')->getData());
            $contact->setLastname($form->get('lastname')->getData());
            $contact->setEmail($form->get('email')->getData());
            $contact->setSubject($form->get('subject')->getData());
            $contact->setContent($form->get('content')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'categs' => $getCategorieService->categorie()
        ]);
    }
}
