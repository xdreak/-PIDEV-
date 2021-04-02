<?php

namespace App\Entity;

use App\Repository\LikeArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeArticleRepository::class)
 */
class LikeArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Artiles::class, inversedBy="likes")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likesU")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Artiles
    {
        return $this->article;
    }

    public function setArticle(?Artiles $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
