<?php

namespace App\Entity;

use App\Repository\NomDeCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NomDeCodeRepository::class)]
class NomDeCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $code;

    #[ORM\OneToOne(mappedBy: 'nom_de_code', targetEntity: Agents::class, cascade: ['persist', 'remove'])]
    private $agents;

    #[ORM\OneToOne(mappedBy: 'nom_de_code', targetEntity: Cibles::class, cascade: ['persist', 'remove'])]
    private $cibles;

    #[ORM\OneToOne(mappedBy: 'nom_de_code', targetEntity: Contacts::class, cascade: ['persist', 'remove'])]
    private $contacts;

    #[ORM\OneToOne(mappedBy: 'code', targetEntity: Planques::class, cascade: ['persist', 'remove'])]
    private $planques;

    #[ORM\OneToOne(mappedBy: 'nom_de_code', targetEntity: Missions::class, cascade: ['persist', 'remove'])]
    private $missions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAgents(): ?Agents
    {
        return $this->agents;
    }

    public function setAgents(Agents $agents): self
    {
        // set the owning side of the relation if necessary
        if ($agents->getNomDeCode() !== $this) {
            $agents->setNomDeCode($this);
        }

        $this->agents = $agents;

        return $this;
    }

    public function getCibles(): ?Cibles
    {
        return $this->cibles;
    }

    public function setCibles(Cibles $cibles): self
    {
        // set the owning side of the relation if necessary
        if ($cibles->getNomDeCode() !== $this) {
            $cibles->setNomDeCode($this);
        }

        $this->cibles = $cibles;

        return $this;
    }

    public function getContacts(): ?Contacts
    {
        return $this->contacts;
    }

    public function setContacts(Contacts $contacts): self
    {
        // set the owning side of the relation if necessary
        if ($contacts->getNomDeCode() !== $this) {
            $contacts->setNomDeCode($this);
        }

        $this->contacts = $contacts;

        return $this;
    }

    public function getPlanques(): ?Planques
    {
        return $this->planques;
    }

    public function setPlanques(Planques $planques): self
    {
        // set the owning side of the relation if necessary
        if ($planques->getCode() !== $this) {
            $planques->setCode($this);
        }

        $this->planques = $planques;

        return $this;
    }

    public function getMissions(): ?Missions
    {
        return $this->missions;
    }

    public function setMissions(Missions $missions): self
    {
        // set the owning side of the relation if necessary
        if ($missions->getNomDeCode() !== $this) {
            $missions->setNomDeCode($this);
        }

        $this->missions = $missions;

        return $this;
    }
}
