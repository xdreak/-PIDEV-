<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $q5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $r5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $c5;

    /**
     * @ORM\OneToOne(targetEntity=OffreStage::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Id_StageQ;

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

    public function getQ1(): ?string
    {
        return $this->q1;
    }

    public function setQ1(?string $q1): self
    {
        $this->q1 = $q1;

        return $this;
    }

    public function getR1(): ?string
    {
        return $this->r1;
    }

    public function setR1(?string $r1): self
    {
        $this->r1 = $r1;

        return $this;
    }

    public function getC1(): ?string
    {
        return $this->c1;
    }

    public function setC1(?string $c1): self
    {
        $this->c1 = $c1;

        return $this;
    }

    public function getQ2(): ?string
    {
        return $this->q2;
    }

    public function setQ2(?string $q2): self
    {
        $this->q2 = $q2;

        return $this;
    }

    public function getR2(): ?string
    {
        return $this->r2;
    }

    public function setR2(?string $r2): self
    {
        $this->r2 = $r2;

        return $this;
    }

    public function getC2(): ?string
    {
        return $this->c2;
    }

    public function setC2(?string $c2): self
    {
        $this->c2 = $c2;

        return $this;
    }

    public function getQ3(): ?string
    {
        return $this->q3;
    }

    public function setQ3(?string $q3): self
    {
        $this->q3 = $q3;

        return $this;
    }

    public function getR3(): ?string
    {
        return $this->r3;
    }

    public function setR3(?string $r3): self
    {
        $this->r3 = $r3;

        return $this;
    }

    public function getC3(): ?string
    {
        return $this->c3;
    }

    public function setC3(?string $c3): self
    {
        $this->c3 = $c3;

        return $this;
    }

    public function getQ4(): ?string
    {
        return $this->q4;
    }

    public function setQ4(?string $q4): self
    {
        $this->q4 = $q4;

        return $this;
    }

    public function getR4(): ?string
    {
        return $this->r4;
    }

    public function setR4(?string $r4): self
    {
        $this->r4 = $r4;

        return $this;
    }

    public function getC4(): ?string
    {
        return $this->c4;
    }

    public function setC4(?string $c4): self
    {
        $this->c4 = $c4;

        return $this;
    }

    public function getQ5(): ?string
    {
        return $this->q5;
    }

    public function setQ5(?string $q5): self
    {
        $this->q5 = $q5;

        return $this;
    }

    public function getR5(): ?string
    {
        return $this->r5;
    }

    public function setR5(?string $r5): self
    {
        $this->r5 = $r5;

        return $this;
    }

    public function getC5(): ?string
    {
        return $this->c5;
    }

    public function setC5(?string $c5): self
    {
        $this->c5 = $c5;

        return $this;
    }

    public function getIdStageQ(): ?OffreStage
    {
        return $this->Id_StageQ;
    }

    public function setIdStageQ(OffreStage $Id_StageQ): self
    {
        $this->Id_StageQ = $Id_StageQ;

        return $this;
    }

}
