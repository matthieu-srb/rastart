<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *@Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide."
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];


    /**
     * @Assert\NotBlank
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(message = "Cette valeur ne peut pas être vide")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit pas contenir de nombre"
     * )
     *  @Assert\Length(max="100", min="3",
     *      minMessage="Le nom de la sortie doit au mininmum contenir 3 caractères ")
     *      maxMessage="Le nom de la sortie doit au maximum contenir 100 caractères ")
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message = "Cette valeur ne peut pas être vide")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne doit pas contenir de nombre"
     * )
     *  @Assert\Length(max="50", min="3",
     *      minMessage="Le nom de la sortie doit au mininmum contenir 3 caractères ")
     *      maxMessage="Le nom de la sortie doit au maximum contenir 50 caractères ")
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ville;

    /**
     * Assert\Regex(
     *     pattern="/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/",
     *     match=true,
     *     message="Le format du numéro de téléphone est incorrect"
     * )
     *  @Assert\Length(max="15", min="8",
     *      minMessage="Un numero de téléphone doit au mininmum contenir 10 caractères  ")
     *      maxMessage="Un numero de téléphone doit au mininmum contenir 15 caractères ")
     * @ORM\Column(type="string", length=15, nullable=true)
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity=festival::class, inversedBy="id_user")
     */
    private $id_festival;

    /**
     * @ORM\ManyToMany(targetEntity=event::class, inversedBy="idUser")
     */
    private $idEvent;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biographie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @Assert\Image(maxSize="1M", maxHeight="1920", maxWidth="1080")
     */
    private $imageFile;

    public function __construct()
    {
        $this->id_festival = new ArrayCollection();
        $this->idEvent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(?string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(?int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|festival[]
     */
    public function getIdFestival(): Collection
    {
        return $this->id_festival;
    }

    public function addIdFestival(festival $idFestival): self
    {
        if (!$this->id_festival->contains($idFestival)) {
            $this->id_festival[] = $idFestival;
        }

        return $this;
    }

    public function removeIdFestival(festival $idFestival): self
    {
        $this->id_festival->removeElement($idFestival);

        return $this;
    }

    /**
     * @return Collection|event[]
     */
    public function getIdEvent(): Collection
    {
        return $this->idEvent;
    }

    public function addIdEvent(event $idEvent): self
    {
        if (!$this->idEvent->contains($idEvent)) {
            $this->idEvent[] = $idEvent;
        }

        return $this;
    }

    public function removeIdEvent(event $idEvent): self
    {
        $this->idEvent->removeElement($idEvent);

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(?string $biographie): self
    {
        $this->biographie = $biographie;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
