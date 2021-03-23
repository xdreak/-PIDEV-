<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Title is required")
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ville is required")
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Domain is required")
     */
    private $Domain;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $CompanyName;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Salaire is required")
     */
    private $Salaire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Type is required")
     */
    private $Type;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Description is required")
     */
    private $Description;

    /**
     * @ORM\OneToMany(targetEntity=Demande::class, mappedBy="RelatedOffre")
     */
    private $ListDemande;

    /**
     * @ORM\OneToOne(targetEntity=Quiz::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Test;


    public function __construct()
    {
        $this->ListDemande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->Domain;
    }

    public function setDomain(string $Domain): self
    {
        $this->Domain = $Domain;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(string $CompanyName): self
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->Salaire;
    }

    public function setSalaire(int $Salaire): self
    {
        $this->Salaire = $Salaire;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

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

    /**
     * @return Collection|Demande[]
     */
    public function getListDemande(): Collection
    {
        return $this->ListDemande;
    }

    public function addListDemande(Demande $listDemande): self
    {
        if (!$this->ListDemande->contains($listDemande)) {
            $this->ListDemande[] = $listDemande;
            $listDemande->setRelatedOffre($this);
        }

        return $this;
    }

    public function removeListDemande(Demande $listDemande): self
    {
        if ($this->ListDemande->removeElement($listDemande)) {
            // set the owning side to null (unless already changed)
            if ($listDemande->getRelatedOffre() === $this) {
                $listDemande->setRelatedOffre(null);
            }
        }

        return $this;
    }

    public function getTest(): ?Quiz
    {
        return $this->Test;
    }

    public function setTest(Quiz $Test): self
    {
        $this->Test = $Test;

        return $this;
    }

}
