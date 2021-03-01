<?php

namespace App\Entity;

use App\Repository\OffreStageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreStageRepository::class)
 */
class OffreStage
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
    private $NomEntreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomStage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DescriptionStage;
    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNomEntreprise(): ?string
    {
        return $this->NomEntreprise;
    }

    public function setNomEntreprise(string $NomEntreprise): self
    {
        $this->NomEntreprise = $NomEntreprise;

        return $this;
    }

    public function getNomStage(): ?string
    {
        return $this->NomStage;
    }

    public function setNomStage(string $NomStage): self
    {
        $this->NomStage = $NomStage;

        return $this;
    }

    public function getDescriptionStage(): ?string
    {
        return $this->DescriptionStage;
    }

    public function setDescriptionStage(string $DescriptionStage): self
    {
        $this->DescriptionStage = $DescriptionStage;

        return $this;
    }


}
