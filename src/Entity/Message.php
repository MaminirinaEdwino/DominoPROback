<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\MaxDepth;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

#[ORM\Entity(repositoryClass: MessageRepository::class)]

#[ApiResource(
    normalizationContext:['groups'=>['message', 'envoyer']],
   
)]
#[ApiFilter(
    SearchFilter::class, properties:['expediteur'=>'exact', 'destinataire'=>'exact'],
)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('message')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('message')]
    
    private ?string $contenue = null;

    #[ORM\ManyToOne(inversedBy: 'messageEnvoye')]
    #[Groups('message')]
    #[MaxDepth(5)]
    private ?Joueur $expediteur = null;

    #[ORM\ManyToOne(inversedBy: 'messageRecu')]
    #[Groups('message')]
    #[MaxDepth(5)]
    private ?Joueur $destinataire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(?string $contenue): static
    {
        $this->contenue = $contenue;

        return $this;
    }

    public function getExpediteur(): ?Joueur
    {
        return $this->expediteur;
    }

    public function setExpediteur(?Joueur $expediteur): static
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire():Joueur
    {
        return $this->destinataire;
    }

    public function setDestinataire(?Joueur $destinataire): static
    {
        $this->destinataire = $destinataire;

        return $this;
    }
    public function __toString()
    {
        $this->getContenue();
    }
}
