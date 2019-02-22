<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 03.02.19
 * Time: 11:23
 */

namespace App\Post;


use App\DTO\PostDto;
use App\Entity\Post;

class PostMapper
{
    public function EntityToDto(Post $entity):PostDto
    {
        $dto =  new PostDto();

        $dto->setAbout($entity->getAbout());
        $dto->setText($entity->getText());
        $dto->setTitle($entity->getTitle());

        return $dto;
    }
}