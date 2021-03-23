<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $Q1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $R1;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $Q2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $R2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $Q3;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $R3;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $Q4;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $R4;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $Q5;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="CompanyName is required")
     */
    private $R5;

    /**
     * @ORM\OneToOne(targetEntity=Offre::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $finder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQ1(): ?string
    {
        return $this->Q1;
    }

    public function setQ1(string $Q1): self
    {
        $this->Q1 = $Q1;

        return $this;
    }

    public function getR1(): ?string
    {
        return $this->R1;
    }

    public function setR1(string $R1): self
    {
        $this->R1 = $R1;

        return $this;
    }

    public function getQ2(): ?string
    {
        return $this->Q2;
    }

    public function setQ2(string $Q2): self
    {
        $this->Q2 = $Q2;

        return $this;
    }

    public function getR2(): ?string
    {
        return $this->R2;
    }

    public function setR2(string $R2): self
    {
        $this->R2 = $R2;

        return $this;
    }

    public function getQ3(): ?string
    {
        return $this->Q3;
    }

    public function setQ3(string $Q3): self
    {
        $this->Q3 = $Q3;

        return $this;
    }

    public function getR3(): ?string
    {
        return $this->R3;
    }

    public function setR3(string $R3): self
    {
        $this->R3 = $R3;

        return $this;
    }

    public function getQ4(): ?string
    {
        return $this->Q4;
    }

    public function setQ4(string $Q4): self
    {
        $this->Q4 = $Q4;

        return $this;
    }

    public function getR4(): ?string
    {
        return $this->R4;
    }

    public function setR4(string $R4): self
    {
        $this->R4 = $R4;

        return $this;
    }

    public function getQ5(): ?string
    {
        return $this->Q5;
    }

    public function setQ5(string $Q5): self
    {
        $this->Q5 = $Q5;

        return $this;
    }

    public function getR5(): ?string
    {
        return $this->R5;
    }

    public function setR5(string $R5): self
    {
        $this->R5 = $R5;

        return $this;
    }

    public function getFinder(): ?Offre
    {
        return $this->finder;
    }

    public function setFinder(Offre $finder): self
    {
        $this->finder = $finder;

        return $this;
    }
}
