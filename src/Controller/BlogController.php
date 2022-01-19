<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Twig\AppExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog', methods: ['GET'])]
    public function blog(): Response
    {
        return $this->render('blog/account.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    #[Route('/blog/{id<\d+>}/{slug}', name: 'blog_show', methods: ['GET'])]
    public function showAction($id, $slug, $comments = true)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository(Blog::class)->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        $comments = $em->getRepository(Comment::class)
            ->getCommentsForBlog($blog->getId());

        return $this->render('blog/show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }



}
