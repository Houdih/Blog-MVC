<?php

namespace App\Src\Entite;

use App\Src\Modele\UserModele;

class User
{
    private ?int $id;
    private ?string $mail;
    private ?string $pass;
    private array $roles;

    public function __construct($data)
    {
        $userModele = new UserModele();
        $userModele->hydrate($data, $this);
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail($mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function setPass($pass): self
    {
        $this->pass = $pass;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles($roles): self
    {
        $this->roles = json_decode($roles);

        return $this;
    }
}