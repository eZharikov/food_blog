<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/registration', name: 'registration_form', methods: ['GET'])]
    public function registrationForm(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }
        return $this->render('account/registration.html.twig');
    }


    #[Route('/registration', name: 'registration_user', methods: ['POST'])]
    public function registrationUser(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {

        $registrationData = $request->request;

        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['login' => $registrationData->get('login')]);
        if ($user) {
            return $this->render('account/registration.html.twig',
                ['error' => 'Пользователь с таким логином уже существует']);
        }

        $user = new User();
        $user->setLogin($registrationData->get('login'));
        $hash = $passwordEncoder->hashPassword($user, $registrationData->get('password'));
        $user->setHash($hash);
        $user->setName($registrationData->get('name'));
        $user->setLastname($registrationData->get('lastname'));
        $user->setEmail($registrationData->get('email'));

        $user->setRoles(['ROLE_USER']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('login_form');
    }

    #[Route('/login', name: 'login_form')]
    public function loginForm(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('account');
        }
        return $this->render('account/login.html.twig');
    }
    #[Route('/account', name: 'account', methods: ['GET'])]
    #[Route('/account/{route}', name: 'vue_pages', requirements: ['page' => '^.+'], methods: ['GET'])]
    public function account(): Response
    {
        $user = $this->getUser();
//        dump($user);
//        dump($user->getId());
        $entityManager = $this->getDoctrine()->getManager();
        $blogRepository = $entityManager->getRepository(Blog::class);
        $blogs = $blogRepository->findAllByUserId($user->getId());
        return $this->render('account/account.html.twig', array(
        'blogs' => $blogs
    ));
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // метод реализован в firewall
    }
}
