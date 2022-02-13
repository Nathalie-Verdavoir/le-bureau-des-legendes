<?php

namespace App\Entity;

use App\Repository\MissionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionsRepository::class)]
class Missions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\OneToOne(inversedBy: 'missions', targetEntity: NomDeCode::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $nom_de_code;

    #[ORM\ManyToOne(targetEntity: Pays::class, inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: true)]
    private $pays;

    #[ORM\ManyToMany(targetEntity: Agents::class, inversedBy: 'missions')]
    private $agents;

    #[ORM\ManyToMany(targetEntity: Contacts::class, inversedBy: 'missions')]
    private $contacts;

    #[ORM\ManyToMany(targetEntity: Cibles::class, inversedBy: 'missions')]
    private $Cibles;

    #[ORM\ManyToOne(targetEntity: TypeDeMissions::class, inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private $statut;

    #[ORM\ManyToMany(targetEntity: Planques::class, inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private $planques;

    #[ORM\ManyToOne(targetEntity: Specialites::class, inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private $specialite;

    #[ORM\Column(type: 'date')]
    private $date_debut;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_fin;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->Cibles = new ArrayCollection();
        $this->planques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getNomDeCode(): ?NomDeCode
    {
        return $this->nom_de_code;
    }

    public function setNomDeCode(NomDeCode $nom_de_code): self
    {
        $this->nom_de_code = $nom_de_code;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|Agents[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agents $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
        }

        return $this;
    }

    public function removeAgent(Agents $agent): self
    {
        $this->agents->removeElement($agent);

        return $this;
    }

    /**
     * @return Collection|Contacts[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        $this->contacts->removeElement($contact);

        return $this;
    }

    /**
     * @return Collection|Cibles[]
     */
    public function getCibles(): Collection
    {
        return $this->Cibles;
    }

    public function addCible(Cibles $cible): self
    {
        if (!$this->Cibles->contains($cible)) {
            $this->Cibles[] = $cible;
        }

        return $this;
    }

    public function removeCible(Cibles $cible): self
    {
        $this->Cibles->removeElement($cible);

        return $this;
    }

    public function getType(): ?TypeDeMissions
    {
        return $this->type;
    }

    public function setType(?TypeDeMissions $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatut(): ?Status
    {
        return $this->statut;
    }

    public function setStatut(?Status $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Planques[]
     */
    public function getPlanques(): Collection
    {
        return $this->planques;
    }

    public function addPlanque(Planques $planque): self
    {
        if (!$this->planques->contains($planque)) {
            $this->planques[] = $planque;
        }

        return $this;
    }

    public function removePlanque(Planques $planque): self
    {
        $this->planques->removeElement($planque);

        return $this;
    }

    public function getSpecialite(): ?Specialites
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialites $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }
    
    
    public function __toString()
    {
        return $this->titre;
    }
}
