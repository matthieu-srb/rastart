<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $style;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=Artiste::class, mappedBy="idEvent")
     */
    private $idArtiste;

    /**
     * @ORM\Column(type="integer")
     */
    private $idRegion;

    public function __construct()
    {
        $this->idArtiste = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Artiste[]
     */
    public function getIdArtiste(): Collection
    {
        return $this->idArtiste;
    }

    public function addIdArtiste(Artiste $idArtiste): self
    {
        if (!$this->idArtiste->contains($idArtiste)) {
            $this->idArtiste[] = $idArtiste;
            $idArtiste->addIdEvent($this);
        }

        return $this;
    }

    public function removeIdArtiste(Artiste $idArtiste): self
    {
        if ($this->idArtiste->removeElement($idArtiste)) {
            $idArtiste->removeIdEvent($this);
        }

        return $this;
    }

    public function getIdRegion(): ?int
    {
        return $this->idRegion;
    }

    public function setIdRegion(int $idRegion): self
    {
        $this->idRegion = $idRegion;

        return $this;
    }
}
