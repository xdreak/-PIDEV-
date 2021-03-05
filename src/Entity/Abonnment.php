<?php

namespace App\Entity;

use App\Repository\AbonnmentRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=AbonnmentRepository::class)
 */
class Abonnment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TitreFormation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Statue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUser(): ?string
    {
        return $this->NomUser;
    }

    public function setNomUser(string $NomUser): self
    {
        $this->NomUser = $NomUser;

        return $this;
    }

    public function getTitreFormation(): ?string
    {
        return $this->TitreFormation;
    }

    public function setTitreFormation(string $TitreFormation): self
    {
        $this->TitreFormation = $TitreFormation;

        return $this;
    }

    public function getStatue(): ?string
    {
        return $this->Statue;
    }

    public function setStatue(string $Statue): self
    {
        $this->Statue = $Statue;

        return $this;
    }
}
