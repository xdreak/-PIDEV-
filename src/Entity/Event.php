<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="10" , minMessage="Champs ne contient que 10 caractéres")
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     * @Assert\GreaterThan("today")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     * @Assert\Expression(
     *     "this.getDatedebut() < this.getDatefin()",
     *     message="La date fin ne doit pas être antérieure à la date début"
     * )
     */
    private $datefin;

    /**
     * @ORM\Column(type="text")
     */
    private $plan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $creatorId;

    /**
     * @ORM\OneToMany(targetEntity=EventParticipations::class, mappedBy="event")
     */
    private $participant;

    public function __construct()
    {
        $this->participant = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getPlan(): ?string
    {
        return $this->plan;
    }

    public function setPlan(string $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

public function getCreatorId(): ?int
{
    return $this->creatorId;
}

public function setCreatorId(int $creatorId): self
{
    $this->creatorId = $creatorId;

    return $this;
}

/**
 * @return Collection|EventParticipations[]
 */
public function getParticipant(): Collection
{
    return $this->participant;
}

public function addParticipant(EventParticipations $participant): self
{
    if (!$this->participant->contains($participant)) {
        $this->participant[] = $participant;
        $participant->setEvent($this);
    }

    return $this;
}

public function removeParticipant(EventParticipations $participant): self
{
    if ($this->participant->removeElement($participant)) {
        // set the owning side to null (unless already changed)
        if ($participant->getEvent() === $this) {
            $participant->setEvent(null);
        }
    }

    return $this;
}
    /**
     * permet de retourner si cet event est participé par utilisateur
     * @param \App\Entity\User $user
     * @return bool
     */
    public function isParticipatedBy(User $user):bool{
        foreach ($this->participant as $participant){
            if($participant->getUser()== $user) return true;
        }
        return false;
    }

}

