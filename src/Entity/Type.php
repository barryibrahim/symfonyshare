<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Userstatus>
     */
    #[ORM\OneToMany(targetEntity: Userstatus::class, mappedBy: 'type', orphanRemoval: true)]
    private Collection $userstatuses;

    public function __construct()
    {
        $this->userstatuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Userstatus>
     */
    public function getUserstatuses(): Collection
    {
        return $this->userstatuses;
    }

    public function addUserstatus(Userstatus $userstatus): static
    {
        if (!$this->userstatuses->contains($userstatus)) {
            $this->userstatuses->add($userstatus);
            $userstatus->setType($this);
        }

        return $this;
    }

    public function removeUserstatus(Userstatus $userstatus): static
    {
        if ($this->userstatuses->removeElement($userstatus)) {
            // set the owning side to null (unless already changed)
            if ($userstatus->getType() === $this) {
                $userstatus->setType(null);
            }
        }

        return $this;
    }
}
