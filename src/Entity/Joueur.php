<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\JoueurRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Controller\NewUserController;
use App\Controller\SecurityController;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Response;
use App\Controller\MeController;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    normalizationContext:['groups'=>['relation']]
)]
#[Post(
    name:'login',
    routeName:'api_login'
)]
#[Post(
    name:'Nouveau Joueur',
    controller:NewUserController::class,
    uriTemplate:'/Joueur/new'
)]
#[Post(
    name:'logout',
    routeName:'api_logout'
)]
#[Patch(
    name:'Modifer Main',
    denormalizationContext:['groups'=>['write:main']],
    uriTemplate:'/joueur/main/{id}'
)]
#[Patch(
    name:'Modif Point',
    uriTemplate:'/joueur/point/{id}',
    denormalizationContext:['groups'=>['write:point']]
)]
#[Patch(
    name:'Modif Table',
    uriTemplate:'/joueur/table/{id}',
    denormalizationContext:['groups'=>['write:table']]
)]
#[Get(
    name:'recup table',
    uriTemplate:'/joueur/table/{id}',
    normalizationContext:['groups'=>['read:table']]
)]
#[Get(
    name:'Recuperer Point',
    uriTemplate:'/joueur/point/{id}',
    normalizationContext:['groups'=>['read:point']]
)]
#[Get(
    name: 'Recuperer Main joueur',
    normalizationContext: ['groups' => ['read:main']],
    uriTemplate: '/joueur/main/{id}'
)]
#[GetCollection()]
#[Get()]

#[Put()]
#[Patch()]
#[Delete()]
#[GetCollection(
    name:'me',
    uriTemplate:'/joueur/info/me',
    controller:MeController::class,
    normalizationContext:['groups'=>['read:me']]
)]
//security:"is_granted('ROLE_USER')"
class Joueur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:me', 'relation', 'jeux'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups('message', 'relation')]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['write:main', 'read:main', 'relation', 'jeux'])]
    private ?array $main = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:point', 'write:point', 'read:me', 'relation' , 'jeux'])]
    private ?int $point = null;

    #[ORM\ManyToOne(inversedBy: 'joueur')]
    #[Groups(['read:table', 'write:table', 'read:me', 'relation'])]
    private ?TableDeJeu $tableDeJeu = null;

    /**
     * @var Collection<int, Message>
    */
    #[ORM\ManyToMany(targetEntity: Message::class, mappedBy: 'expediteur')]
    #[Groups('message')]
    private Collection $messages;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'expediteur')]
    #[MaxDepth(5)]
    private Collection $messageEnvoye;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'destinataire')]
    #[MaxDepth(5)]
    private Collection $messageRecu;

    #[ORM\Column(length: 255)]
    #[Groups(['read:me', 'message', 'relation', 'jeux'])]
    private ?string $nomJoueur = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:me', 'relation'])]
    private ?bool $enligne = null;

    /**
     * @var Collection<int, DemandeDeMatch>
     */
    #[ORM\OneToMany(targetEntity: DemandeDeMatch::class, mappedBy: 'Demandeur')]
    private Collection $demandeEnvoyer;

    /**
     * @var Collection<int, DemandeDeMatch>
     */
    
    #[ORM\OneToMany(targetEntity: DemandeDeMatch::class, mappedBy: 'cible')]
    private Collection $demandeRecu;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->messageEnvoye = new ArrayCollection();
        $this->messageRecu = new ArrayCollection();
        $this->demandeEnvoyer = new ArrayCollection();
        $this->demandeRecu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMain(): ?array
    {
        return $this->main;
    }

    public function setMain(?array $main): static
    {
        $this->main = $main;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(?int $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getTableDeJeu(): ?TableDeJeu
    {
        return $this->tableDeJeu;
    }

    public function setTableDeJeu(?TableDeJeu $tableDeJeu): static
    {
        $this->tableDeJeu = $tableDeJeu;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessageEnvoye(): Collection
    {
        return $this->messageEnvoye;
    }

    public function addMessageEnvoye(Message $messageEnvoye): static
    {
        if (!$this->messageEnvoye->contains($messageEnvoye)) {
            $this->messageEnvoye->add($messageEnvoye->getContenue());
            $messageEnvoye->setExpediteur($this);
        }

        return $this;
    }

    public function removeMessageEnvoye(Message $messageEnvoye): static
    {
        if ($this->messageEnvoye->removeElement($messageEnvoye)) {
            // set the owning side to null (unless already changed)
            if ($messageEnvoye->getExpediteur() === $this) {
                $messageEnvoye->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessageRecu(): Collection
    {
        return $this->messageRecu;
    }

    public function addMessageRecu(Message $messageRecu): static
    {
        if (!$this->messageRecu->contains($messageRecu)) {
            $this->messageRecu->add($messageRecu);
            $messageRecu->setDestinataire($this);
        }

        return $this;
    }

    public function removeMessageRecu(Message $messageRecu): static
    {
        if ($this->messageRecu->removeElement($messageRecu)) {
            // set the owning side to null (unless already changed)
            if ($messageRecu->getDestinataire() === $this) {
                $messageRecu->setDestinataire(null);
            }
        }

        return $this;
    }

    public function getNomJoueur(): ?string
    {
        return $this->nomJoueur;
    }

    public function setNomJoueur(string $nomJoueur): static
    {
        $this->nomJoueur = $nomJoueur;

        return $this;
    }

    public function isEnligne(): ?bool
    {
        return $this->enligne;
    }

    public function setEnligne(?bool $enligne): static
    {
        $this->enligne = $enligne;

        return $this;
    }

    /**
     * @return Collection<int, DemandeDeMatch>
     */
    public function getDemandeEnvoyer(): Collection
    {
        return $this->demandeEnvoyer;
    }

    public function addDemandeEnvoyer(DemandeDeMatch $demandeEnvoyer): static
    {
        if (!$this->demandeEnvoyer->contains($demandeEnvoyer)) {
            $this->demandeEnvoyer->add($demandeEnvoyer);
            $demandeEnvoyer->setDemandeur($this);
        }

        return $this;
    }

    public function removeDemandeEnvoyer(DemandeDeMatch $demandeEnvoyer): static
    {
        if ($this->demandeEnvoyer->removeElement($demandeEnvoyer)) {
            // set the owning side to null (unless already changed)
            if ($demandeEnvoyer->getDemandeur() === $this) {
                $demandeEnvoyer->setDemandeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemandeDeMatch>
     */
    public function getDemandeRecu(): Collection
    {
        return $this->demandeRecu;
    }

    public function addDemandeRecu(DemandeDeMatch $demandeRecu): static
    {
        if (!$this->demandeRecu->contains($demandeRecu)) {
            $this->demandeRecu->add($demandeRecu);
            $demandeRecu->setCible($this);
        }

        return $this;
    }

    public function removeDemandeRecu(DemandeDeMatch $demandeRecu): static
    {
        if ($this->demandeRecu->removeElement($demandeRecu)) {
            // set the owning side to null (unless already changed)
            if ($demandeRecu->getCible() === $this) {
                $demandeRecu->setCible(null);
            }
        }

        return $this;
    }
}
