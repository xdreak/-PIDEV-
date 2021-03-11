<?php

namespace App\Entity;

use App\Repository\OffreStageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @Assert\NotBlank
     */
    private $NomEntreprise;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $Description;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $stage_id;

    /**
     * @ORM\OneToMany(targetEntity=CandidatureStage::class, mappedBy="id_stage")
     */
    private $relation;

    /**
     * @ORM\OneToOne(targetEntity=Quiz::class, cascade={"persist", "remove"})
     */
    private $finder;
    /*
    /**
     * @ORM\OneToOne(targetEntity=Quiz::class, mappedBy="Id_stageQ")
     */
    //private $relation2;

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



    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getStageId(): ?string
    {
        return $this->stage_id;
    }

    public function setStageId(string $stage_id): self
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
/*
    /**
     * @return Collection|Quiz[]
     */
   /*
    public function getRelation2(): Collection
    {
        return $this->relation2;
    }

    public function addRelation2(Quiz $relation2): self
    {
        if (!$this->relation2->contains($relation2)) {
            $this->relation2[] = $relation2;
            $relation2->setIdStageQ($this);
        }

        return $this;
    }

    public function removeRelation2(Quiz $relation2): self
    {
        if ($this->relation2->removeElement($relation2)) {
            // set the owning side to null (unless already changed)
            if ($relation2->getIdStageQ() === $this) {
                $relation2->setIdStageQ(null);
            }
        }

        return $this;
    }*/
    public function __toString()
    {
        return (string) $this->stage_id;
    }

    public function getFinder(): ?Quiz
    {
        return $this->finder;
    }

    public function setFinder(?Quiz $finder): self
    {
        $this->finder = $finder;

        return $this;
    }



}
