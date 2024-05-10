<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TableDeJeuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: TableDeJeuRepository::class)]
#[ApiResource()]

#[GetCollection()]
#[Get(
    normalizationContext:['groups'=>['jeux']]
)]
#[Post()]
#[Put()]
#[Patch()]
#[Delete()]

class TableDeJeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Table', 'relation', 'jeux'])]
    private ?int $id = null;

    #[Groups(['read:Table', 'relation', 'jeux'])]
    #[ORM\Column(nullable: true)]
    private ?array $dominoPlace = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:Table', 'jeux'])]
    private ?int $nombreJoueur = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:Table', 'relation', 'jeux'])]
    private ?int $nombreManche = null;

    /**
     * @var Collection<int, Joueur>
     */
    #[ORM\OneToMany(targetEntity: Joueur::class, mappedBy: 'tableDeJeu')]
    #[Groups(['read:joueurTable', 'read:Table', 'jeux'])]
    #[MaxDepth(5)]
    private Collection $joueur;

    /**
     * @var Collection<int, DemandeDeMatch>
     */
    #[ORM\OneToMany(targetEntity: DemandeDeMatch::class, mappedBy: 'tableDeJeu')]
    private Collection $demandeDeMatches;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:Table', 'relation', 'jeux'])]
    private ?bool $partieLance = null;

    #[ORM\Column(nullable: true)]
    #[Groups('jeux')]
    private ?int $tourDe = null;

    public function __construct()
    {
        $this->joueur = new ArrayCollection();
        $this->demandeDeMatches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDominoPlace(): ?array
    {
        return $this->dominoPlace;
    }

    public function setDominoPlace(?array $dominoPlace): static
    {
        $this->dominoPlace = $dominoPlace;

        return $this;
    }

    public function getNombreJoueur(): ?int
    {
        return $this->nombreJoueur;
    }

    public function setNombreJoueur(?int $nombreJoueur): static
    {
        $this->nombreJoueur = $nombreJoueur;

        return $this;
    }

    public function getNombreManche(): ?int
    {
        return $this->nombreManche;
    }

    public function setNombreManche(?int $nombreManche): static
    {
        $this->nombreManche = $nombreManche;

        return $this;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getJoueur(): Collection
    {
        return $this->joueur;
    }

    public function addJoueur(Joueur $joueur): static
    {
        if (!$this->joueur->contains($joueur)) {
            $this->joueur->add($joueur);
            $joueur->setTableDeJeu($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): static
    {
        if ($this->joueur->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getTableDeJeu() === $this) {
                $joueur->setTableDeJeu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemandeDeMatch>
     */
    public function getDemandeDeMatches(): Collection
    {
        return $this->demandeDeMatches;
    }

    public function addDemandeDeMatch(DemandeDeMatch $demandeDeMatch): static
    {
        if (!$this->demandeDeMatches->contains($demandeDeMatch)) {
            $this->demandeDeMatches->add($demandeDeMatch);
            $demandeDeMatch->setTableDeJeu($this);
        }

        return $this;
    }

    public function removeDemandeDeMatch(DemandeDeMatch $demandeDeMatch): static
    {
        if ($this->demandeDeMatches->removeElement($demandeDeMatch)) {
            // set the owning side to null (unless already changed)
            if ($demandeDeMatch->getTableDeJeu() === $this) {
                $demandeDeMatch->setTableDeJeu(null);
            }
        }

        return $this;
    }

    public function isPartieLance(): ?bool
    {
        return $this->partieLance;
    }

    public function setPartieLance(?bool $partieLance): static
    {
        $this->partieLance = $partieLance;

        return $this;
    }

    public function getTourDe(): ?int
    {
        return $this->tourDe;
    }

    public function setTourDe(?int $tourDe): static
    {
        $this->tourDe = $tourDe;

        return $this;
    }
}
