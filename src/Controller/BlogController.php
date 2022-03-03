<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $repository, Request $request): Response
    {
        $limit = $request->get("limit", 10);
        $page = $request->get("page", 1);
        $total = $repository->count([]);
        $posts = $repository->findByPagination((int) $page, $limit);
        $pages = ceil($total / $limit);

        $range = range(
            max($page - 3, 1),
            min($page + 3, $pages)
        );

        return $this->render("index.html.twig", [
            "posts" => $posts,
            "pages" => $pages,
            "page"  => $page,
            "limit" => $limit,
            "range" => $range,
        ]);

    }

    /**
     * @Route("/article-{id}", name="blog_read")
     */
    public function read(Post $post, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute("blog_read", ["id" => $post->getId()]);
        }

        return $this->render("read.html.twig", [
            "post" => $post,
            "form" => $form->createView(),
        ]);
    }
}
