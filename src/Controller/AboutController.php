<?php

namespace App\Controller;


use App\Entity\Enquiry;
use App\Form\EnquiryType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AboutController extends AbstractController
{
    #[Route('/about', name: 'about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('about/about.html.twig');
    }
    #[Route('/contacts', name: 'contacts', methods: ['GET'])]
    public function contacts(): Response
    {
        return $this->render('about/contacts.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }

    #[Route('/contacts', name: 'contacts')]
    public function contactForm(Request $request): Response
    {
        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() &&$form->isValid()) {
                // Perform some action, such as sending an email
//                $email = $this->sendEmail($request);
//                    $this->get('session')->getFlashBag()->add('blogger-notice', 'Ваша сообщение успешно отправлено!');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('contacts'));
            }
        }

        return $this->render('about/contacts.html.twig', ['form' => $form->createView()]

        );
    }

}
