<?php

namespace App\Entity;

use App\Repository\PlanquesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanquesRepository::class)]
class Planques
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'planques', targetEntity: NomDeCode::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\ManyToOne(targetEntity: Pays::class, inversedBy: 'planques')]
    #[ORM\JoinColumn(nullable: false)]
    private $pays;

    #[ORM\ManyToOne(targetEntity: TypeDePlanques::class, inversedBy: 'planques', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\ManyToMany(targetEntity: Missions::class, mappedBy: 'planques')]
    private $missions;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?NomDeCode
    {
        return $this->code;
    }

    public function setCode(NomDeCode $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getType(): ?TypeDePlanques
    {
        return $this->type;
    }

    public function setType(?TypeDePlanques $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Missions[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Missions $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->addPlanque($this);
        }

        return $this;
    }

    public function removeMission(Missions $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            $mission->removePlanque($this);
        }

        return $this;
    }
}
