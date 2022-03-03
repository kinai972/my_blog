<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 25; $i++) {
            $post = new Post();
            $post->setTitle("Article N° $i");
            $post->setContent("Contenu N° $i");
            $manager->persist($post);

            for ($j = 0; $j < 15; $j++) {
                $comment = new Comment();
                $comment->setAuthor("Auteur $i");
                $comment->setContent("Commentaire N° $i");
                $manager->persist($comment);
            }
        }
        $manager->flush();
    }
}
