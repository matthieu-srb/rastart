<?php

namespace App\Entity;

use App\Repository\FestivalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FestivalRepository::class)
 */
class Festival
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $descritption;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFestival;

    /**
     * @ORM\OneToOne(targetEntity=Lieu::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idLieu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescritption(): ?string
    {
        return $this->descritption;
    }

    public function setDescritption(string $descritption): self
    {
        $this->descritption = $descritption;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(?\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateFestival(): ?\DateTimeInterface
    {
        return $this->dateFestival;
    }

    public function setDateFestival(\DateTimeInterface $dateFestival): self
    {
        $this->dateFestival = $dateFestival;

        return $this;
    }

    public function getIdLieu(): ?Lieu
    {
        return $this->idLieu;
    }

    public function setIdLieu(Lieu $idLieu): self
    {
        $this->idLieu = $idLieu;

        return $this;
    }
}
