<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $services = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(name: "deuxieme_prenom", type: "string", length: 255, nullable: true)]
    private $deuxieme_prenom;
    

    #[ORM\Column(length: 255)]
    private ?string $nom_de_famille = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, type: 'integer')]
    private $numero_de_telephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServices(): ?string
    {
        return $this->services;
    }

    public function setServices(string $services): self
    {
        $this->services = $services;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDeuxiemePrenom(): ?string
    {
        return $this->deuxieme_prenom;
    }

    public function setDeuxiemePrenom(string $deuxieme_prenom): self
    {
        $this->deuxieme_prenom = $deuxieme_prenom;

        return $this;
    }

    public function getNomDeFamille(): ?string
    {
        return $this->nom_de_famille;
    }

    public function setNomDeFamille(string $nom_de_famille): self
    {
        $this->nom_de_famille = $nom_de_famille;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumeroDeTelephone(): ?int
    {
        return $this->numero_de_telephone;
    }

    public function setNumeroDeTelephone(int $numero_de_telephone): self
    {
        $this->numero_de_telephone = $numero_de_telephone;

        return $this;
    }
}