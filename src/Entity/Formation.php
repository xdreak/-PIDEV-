<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("jihen")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @ASSERT\NotBlank(message="Titre is required")
     * @Groups("jihen")
     */
    private $Titre;

    /**
     * @ORM\Column(type="date")
     * @ASSERT\NotBlank(message="Date is required")
     * @Groups("jihen")
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=255)
     * @ASSERT\NotBlank(message="Lieu is required")
     * @Groups("jihen")
     */
    private $Lieu;

    /**
     * @ORM\Column(type="text")
     * @Groups("jihen")
     */
    private $Description;

    /**
     * @ORM\Column(type="integer")
     * @ASSERT\NotBlank(message="Prix is required")
     * @Groups("jihen")
     */
    private $Prix;

    /**
     * @ORM\Column(type="date")
     * @Groups("jihen")
     */
    private $dateFin;


    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="formations")
     * @Groups("jihen")
     */
    private $category;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): self
    {
        $this->Lieu = $Lieu;

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

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

}
