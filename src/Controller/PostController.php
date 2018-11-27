<?php
/**
 * Created by PhpStorm.
 * User: Vladislav
 * Date: 27.11.2018
 * Time: 16:34
 */

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
{
    /**
     * @Route("/post", name="post")
     */
    public function viewPost()
    {

        $em = $this->getDoctrine()->getManager();

        $post = new Post();
        $post->setHeader('New Stadium!');
        $post->setAuthor('Khakhel Vlad');
        $post->setTeaser('new stadium has been building from Toronto');
        $post->setCreateDate(new \DateTime());
        $post->setLikes(123);
        $post->setContent('eeeee Dinamo!!!');
        $post->setImagePreview("hyperlink");

        // скажите Doctrine, что вы (в итоге) хотите сохранить Товар (пока без запросов)
        $em->persist($post);

        // на самом деле выполнить запросы (т.е. запрос INSERT)
        $em->flush();

        return new Response('Saved new post with id ' . $post->getId());
    }
}