<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Twig\AppExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{
    #[Route('/', name: 'page')]
    public function pageAction(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $blogRepository = $entityManager->getRepository(Blog::class);
        $blogs = $blogRepository->getLatestBlogs();

        return $this->render('Page/index.html.twig', array(
            'blogs' => $blogs
        ));
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getManager();

        $tags = $em->getRepository(Blog::class)
            ->getTags();

        $tagWeights = $em->getRepository(Blog::class)
            ->getTagWeights($tags);

        $commentLimit   = 10;
        $latestComments = $em->getRepository(Comment::class)
            ->getLatestComments($commentLimit);

        return $this->render('Page/sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags' => $tagWeights
        ));
    }

}

