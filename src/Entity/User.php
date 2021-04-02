<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Username is required")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Password is required")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="E-mail is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Role is required")
     *
     */
    private $role;

  /**
     * @ORM\OneToMany(targetEntity=LikeArticle::class, mappedBy="user")
     */
    private $likesU;

    /**
     * @ORM\OneToMany(targetEntity=EventParticipations::class, mappedBy="user")
     */
    private $participation;

    public function __construct()
    {
        $this->likesU = new ArrayCollection();
        $this->participation = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
  /**
     * @return Collection|LikeArticle[]
     */
    public function getLikesU(): Collection
    {
        return $this->likesU;
    }

    public function addLikesU(LikeArticle $likesU): self
    {
        if (!$this->likesU->contains($likesU)) {
            $this->likesU[] = $likesU;
            $likesU->setUser($this);
        }
        return $this;
    }

    public function removeLikesU(LikeArticle $likesU): self
    {
        if ($this->likesU->removeElement($likesU)) {
            // set the owning side to null (unless already changed)
            if ($likesU->getUser() === $this) {
                $likesU->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|EventParticipations[]
     */
    public function getParticipation(): Collection
    {
        return $this->participation;
    }

    public function addParticipation(EventParticipations $participation): self
    {
        if (!$this->participation->contains($participation)) {
            $this->participation[] = $participation;
            $participation->setUser($this);
        }

        return $this;
    }

    public function removeParticipation(EventParticipations $participation): self
    {
        if ($this->participation->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getUser() === $this) {
                $participation->setUser(null);
            }
        }

        return $this;
    }
/**
     * @CaptchaAssert\ValidCaptcha(
     *      message = "CAPTCHA validation failed, try again."
     * )
     */
    protected $captchaCode;

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }

}
