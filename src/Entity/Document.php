<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @Vich\Uploadable
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pdf;
    /**
     * @Vich\UploadableField(mapping="pdf", fileNameProperty="pdf")
     * @var File
     */
    private $pdfFile;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apercu;

    /**
     * @Vich\UploadableField(mapping="image", fileNameProperty="apercu")
     * @var File
     */
    private $apercuFile;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPdf()
    {
        return $this->pdf;
    }

    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * @return File
     */
    public function getPdfFile()
    {
        return $this->pdfFile;
    }

    /**
     * @param File $pdfFile
     */
    public function setPdfFile(File $pdfFile): void
    {
        $this->pdfFile = $pdfFile;
    }


    public function getApercu()
    {
        return $this->apercu;
    }

    /**
     * @return File
     */
    public function getApercuFile()
    {
        return $this->apercuFile;
    }

    /**
     * @param File $apercuFile
     */
    public function setApercuFile(File $apercuFile): void
    {
        $this->apercuFile = $apercuFile;
    }

    public function setApercu($apercu)
    {
        $this->apercu = $apercu;

        return $this;
    }
}
