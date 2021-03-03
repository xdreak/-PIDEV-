<?php

namespace App\Entity;

use App\Repository\OffreStageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $Description;

    /**
     * @ORM\Column(type="integer")
     */
    private $stage_id;

    /**
     * @ORM\OneToMany(targetEntity=CandidatureStage::class, mappedBy="id_stage")
     */
    private $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getStageId(): ?int
    {
        return $this->stage_id;
    }

    public function setStageId(int $stage_id): self
    {
        $this->stage_id = $stage_id;

        return $this;
    }

    /**
     * @return Collection|CandidatureStage[]
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(CandidatureStage $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setIdStage($this);
        }

        return $this;
    }

    public function removeRelation(CandidatureStage $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getIdStage() === $this) {
                $relation->setIdStage(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->stage_id;
    }

}
