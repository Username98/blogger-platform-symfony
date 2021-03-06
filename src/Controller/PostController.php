<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @Route("/post")
 */
class PostController extends Controller

{
    /**
     * @Route("/", name="post_index", methods="GET")
     */
    public function index(Request $request): Response
    {
        $getPosts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findBy(array('isActive' => '1'), array('createDate' => 'DESC'));
        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator = $this->get('knp_paginator');
        $posts = $paginator->paginate($getPosts, $request->query->getInt('page', 1), 10);
        return $this->render('post/index1.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/post/popular", name="post_popular", methods="GET")
     */
    public function getPopular(Request $request): Response
    {
        $getPosts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findBy(array('isActive' => '1'), array('likes' => 'DESC'));
        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator = $this->get('knp_paginator');
        $posts = $paginator->paginate($getPosts, $request->query->getInt('page', 1), 10);
        return $this->render('post/popular.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/post/my", name="my_posts", methods="GET")
     */
    public function getMyPosts(Request $request): Response
    {
        $getPosts = $this->getDoctrine()->getRepository(Post::class)
            ->findBy(
                array('author' => $this->getUser()->getUsername()),
                array('createDate' => 'DESC')
            );
        /* @var $paginator \Knp\Component\Pager\Paginator */
        $paginator = $this->get('knp_paginator');
        $posts = $paginator->paginate($getPosts, $request->query->getInt('page', 1), 10);
        return $this->render('post/myPosts.html.twig', ['posts' => $posts]);
    }
    /**
     * @return string
     */

    /**
     * @Route("/new", name="post_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $post->setAuthor($this->getUser()->getUsername());
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $post->getImagePreview();
            $fileName = $post->generateUniqueFileName() . '.' . $file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('post_directory'),
                    $fileName
                );
            } catch (FileException $e) {
            }
            $post->setImagePreview($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new1.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show" )
     */
    public function show(Post $post, Request $request, ObjectManager $manager): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser()->getUsername());
            $comment->setCreatedAt(new \DateTime())
                ->setPost($post);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }
        return $this->render('post/show1.html.twig', ['post' => $post, 'commentForm' => $form->createView()]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods="GET|POST")
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $post->getImagePreview();
            $fileName = $post->generateUniqueFileName() . '.' . $file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('post_directory'),
                    $fileName
                );
            } catch (FileException $e) {
            }
            $post->setImagePreview($fileName);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('post_index', ['id' => $post->getId()]);
        }

        return $this->render('post/edit1.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods="DELETE")
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
