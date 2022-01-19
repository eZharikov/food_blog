<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    public function sendEmail(MailerInterface $mailer, $enquiry): Response
    {
        $email = (new TemplatedEmail())
            ->subject('[Mail Обратная связь от Food-Blog]')
//            ->from('eijarikov@gmail.com')
//            ->to('evgenyzharikov@gmail.com')
            ->textTemplate('mailer/contactEmail.txt.twig');


        $mailer->send($email);
        return new Response('Сообщение успешно отправлено');

    }
}
