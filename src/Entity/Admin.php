<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends User
{
    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;
    
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}
