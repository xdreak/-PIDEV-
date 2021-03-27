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
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups ("arij")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(min="10")
     * @Groups ("arij")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Groups ("arij")
     */
    private $resume;

    /**
     * @ORM\Column(type="text")
     * @Groups ("arij")
     */
    private $contenu;

    /**
     * @ORM\Column(type="date")
     * @Groups ("arij")
     */
    private $publiele;
    /**
     * @ORM\Column(type="date")
     * @Groups ("arij")
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
     * @Groups ("arij")
     */
    private $image;
    /**
     * @Vich\UploadableField(mapping="image", fileNameProperty="image")
     * @var File
     * @Groups ("arij")
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity=LikeArticle::class, mappedBy="article")
     * @Groups ("arij")
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }
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

    /**
     * @return Collection|LikeArticle[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(LikeArticle $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setArticle($this);
        }

        return $this;
    }

    public function removeLike(LikeArticle $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getArticle() === $this) {
                $like->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * permet de retourner si cet article est liker par utilisateur
     * @param \App\Entity\User $user
     * @return bool
     */
    public function isLikedByUser(User $user):bool{
        foreach ($this->likes as $like){
            if($like->getUser()== $user) return true;
        }
        return false;
    }

}
