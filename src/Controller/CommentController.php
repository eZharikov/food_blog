<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Twig\AppExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentController extends AbstractController
{
    #[Route('/comment', name: 'comment',methods: ['GET'])]
    public function comment(): Response
    {
        return $this->render('comment/account.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
//    #[Route('/comment/{blog_id}', name: 'comment_new',methods: ['GET'])]
    public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(CommentType::class, $comment);

        return $this->render('Comment/form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }
    #[Route('/comment/{blog_id}', name: 'comment_create',methods: ['POST'])]
    public function createAction(Request $request, $blog_id)
    {
        $blog = $this->getBlog($blog_id);
        $user = $this->getUser();

        $comment  = new Comment();
        $comment->setBlog($blog);
        $comment->setUser($user);

        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_show', array(
                'id' => $comment->getBlog()->getId(),
                'slug'  => $comment->getBlog()->getSlug())) .
                '#comment-' . $comment->getId()
            );
        }

        return $this->render('Comment/create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
            ->getManager();

        $blog = $em->getRepository(Blog::class)->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}
