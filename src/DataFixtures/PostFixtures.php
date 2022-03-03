<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $post = new Post();
            $post->setTitle("Article N° $i");
            $post->setContent("Contenu N° $i");
            $manager->persist($post);
        }
        $manager->flush();
    }
}
