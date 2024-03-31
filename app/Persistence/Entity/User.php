<?php

namespace Insid\Blogonslim\Persistence\Entity;

use Insid\Blogonslim\Persistence\ActiveRecordEntity;
use Insid\Blogonslim\Persistence\Util\ConnectionManager;

class User extends ActiveRecordEntity
{
    protected string $login;
    protected string $password;
    protected int $age;

    protected static function getTableName(): string
    {
        return "users";
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}
