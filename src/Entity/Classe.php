<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: EmploiTemps::class)]
    private Collection $emploiTemps;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: ClasseSearch::class)]
    private Collection $classeSearches;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Eleve::class)]
    private Collection $eleves;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Note::class)]
    private Collection $notes;

    public function __construct()
    {
        $this->emploiTemps = new ArrayCollection();
        $this->classeSearches = new ArrayCollection();
        $this->eleves = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
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
     * @return Collection<int, EmploiTemps>
     */
    public function getEmploiTemps(): Collection
    {
        return $this->emploiTemps;
    }

    public function addEmploiTemp(EmploiTemps $emploiTemp): static
    {
        if (!$this->emploiTemps->contains($emploiTemp)) {
            $this->emploiTemps->add($emploiTemp);
            $emploiTemp->setClasse($this);
        }

        return $this;
    }

    public function removeEmploiTemp(EmploiTemps $emploiTemp): static
    {
        if ($this->emploiTemps->removeElement($emploiTemp)) {
            // set the owning side to null (unless already changed)
            if ($emploiTemp->getClasse() === $this) {
                $emploiTemp->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClasseSearch>
     */
    public function getClasseSearches(): Collection
    {
        return $this->classeSearches;
    }

    public function addClasseSearch(ClasseSearch $classeSearch): static
    {
        if (!$this->classeSearches->contains($classeSearch)) {
            $this->classeSearches->add($classeSearch);
            $classeSearch->setClasse($this);
        }

        return $this;
    }

    public function removeClasseSearch(ClasseSearch $classeSearch): static
    {
        if ($this->classeSearches->removeElement($classeSearch)) {
            // set the owning side to null (unless already changed)
            if ($classeSearch->getClasse() === $this) {
                $classeSearch->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Eleve>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleve $elefe): static
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setClasse($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasse() === $this) {
                $elefe->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setClasse($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getClasse() === $this) {
                $note->setClasse(null);
            }
        }

        return $this;
    }

    

    
}
