<?php

namespace App\Entity;

use App\Repository\FestivalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $idUser;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="id_festival")
     */
    private $id_user;

    public function __construct()
    {
        $this->idUser = new ArrayCollection();
        $this->id_user = new ArrayCollection();
    }

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

    /**
     * @return Collection|User[]
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(User $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
        }

        return $this;
    }

    public function removeIdUser(User $idUser): self
    {
        $this->idUser->removeElement($idUser);

        return $this;
    }
}
