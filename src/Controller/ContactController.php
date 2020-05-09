<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\CategoryRepository;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /* INJECTION DE DEPENDANCE*/
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
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
            'categs' => $this->getCategories()
        ]);
    }

    private function getCategories()
    {
        return $this->categoryRepository->findAll();
    }
}
