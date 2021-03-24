<?php

namespace App\Entity;
use App\Entity\User;
use App\Repository\ArtilesRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ArtilesRepository::class)
 * @Vich\Uploadable
 */
class Artiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(min="10")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="date")
     */
    private $publiele;
    /**
     * @ORM\Column(type="date")
     */
    private $majle;

    /**
     * @return mixed
     */
    public function getMajle()
    {
        return $this->majle;
    }

    /**
     * @param mixed $majle
     */
    public function setMajle($majle): void
    {
        $this->majle = $majle;
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;
    /**
     * @Vich\UploadableField(mapping="image", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articlelike", mappedBy="user")
     */
    private $nombrelike;

    /**
     * @param File $imageFile
     */
    public function setImageFile(File $imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPubliele(): ?DateTime
    {
        return $this->publiele;
    }

    public function setPubliele(DateTime $publiele): self
    {
        $this->publiele = $publiele;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
    public function setNombrelike()
    {
        $this->nombrelike = new ArrayCollection();
    }
    /**
     * @return Collection|Articlelike[]
     */
    public function getNombrelike(): Collection
    {
        return $this->nombrelike;
    }
    public function addLike(Articlelike $like): self
    {
        if (!$this->nombrelike->contains($like)) {
            $this->nombrelike[] = $like;
            $like->setArticle($this);
        }
        return $this;
    }

    public function removeLike(Articlelike $like): self
    {
        if ($this->nombrelike->contains($like)) {
            $this->nombrelike->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getArticle() === $this) {
                $like->setArticle(null);
            }
        }

        return $this;
    }

    public function isLikedByUser(User $user): bool
    {
        foreach ($this->nombrelike as $like) {
            if ($like->getUser() === $user) {
                return true;
            }
        }

        return false;
    }

}
