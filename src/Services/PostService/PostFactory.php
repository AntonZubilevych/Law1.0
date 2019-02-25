<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 26.01.19
 * Time: 13:44
 */

namespace App\Services\PostService;


use App\DTO\PostDto;
use App\Entity\Post;
use App\Services\Converter;

class PostFactory
{
    private $convector;

    public function __construct(Converter $convector)
    {
        $this->convector = $convector;
    }

    public function create(Post $dto):Post
    {
        $post =  new Post();
        $post->setTitle($dto->getTitle());
        $post->setAbout($dto->getAbout());
        $post->setText($dto->getText());
        $post->setCratedAt(new \DateTime());
        $post->setStatus(0);
        $post->setUrl($this->convector->createUri($post->getTitle()));

        return $post;
    }
}