<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\DemandeDeMatchRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeDeMatchRepository::class)]
#[ApiResource]
#[ApiFilter(
    SearchFilter::class, properties:['cible'=>'exact']
)]
class DemandeDeMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandeEnvoyer')]
    private ?Joueur $Demandeur = null;

    #[ORM\ManyToOne(inversedBy: 'demandeRecu')]
    private ?Joueur $cible = null;


    #[ORM\Column(nullable: true)]
    private ?bool $choixCible = null;

    #[ORM\ManyToOne(inversedBy: 'demandeDeMatches')]
    private ?TableDeJeu $tableDeJeu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomDemandeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemandeur(): ?Joueur
    {
        return $this->Demandeur;
    }

    public function setDemandeur(?Joueur $Demandeur): static
    {
        $this->Demandeur = $Demandeur;

        return $this;
    }

    public function getCible(): ?Joueur
    {
        return $this->cible;
    }

    public function setCible(?Joueur $cible): static
    {
        $this->cible = $cible;

        return $this;
    }

    public function isChoixCible(): ?bool
    {
        return $this->choixCible;
    }

    public function setChoixCible(?bool $choixCible): static
    {
        $this->choixCible = $choixCible;

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

    public function getNomDemandeur(): ?string
    {
        return $this->nomDemandeur;
    }

    public function setNomDemandeur(?string $nomDemandeur): static
    {
        $this->nomDemandeur = $nomDemandeur;

        return $this;
    }
}
