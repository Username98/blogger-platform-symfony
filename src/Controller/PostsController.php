<?php
/**
 * Created by PhpStorm.
 * User: Vladislav
 * Date: 27.11.2018
 * Time: 16:34
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class PostsController extends AbstractController
{
    /**
     * @Route("/posts", name="logout")
     */
    public function viewPost()
    {
        $post1="vsem privet";
        $post2="post2";
        return $this->render('posts/posts.html.twig',array(
            'post1' => $post1,
            'post2' => $post2,
        ));
    }
}