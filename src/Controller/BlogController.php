<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $repository): Response
    {
        $posts = $repository->findAllWithComments();
        return $this->render("index.html.twig", [
            "posts" => $posts,
        ]);
    }

    /**
     * @Route("/article-{id}", name="blog_read")
     */
    public function read(Post $post): Response
    {
        return $this->render("read.html.twig", [
            "post" => $post,
        ]);
    }
}
