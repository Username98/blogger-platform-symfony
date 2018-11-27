<?php
/**
 * Created by PhpStorm.
 * User: Vladislav
 * Date: 27.11.2018
 * Time: 16:34
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController
{
    /**
     * @Route("/posts", name="logout")
     */
    public function viewPost()
    {
        return new Response("pidor");
    }
}