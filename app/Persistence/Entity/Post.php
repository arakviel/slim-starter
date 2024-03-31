<?php

namespace Insid\Blogonslim\Persistence\Entity;

use Insid\Blogonslim\Persistence\ActiveRecordEntity;

class Post extends ActiveRecordEntity
{
    protected string $title;
    protected string $body;
    protected bool $isPublished;

    protected static function getTableName(): string
    {
        return "posts";
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }
}