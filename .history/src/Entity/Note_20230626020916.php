<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NoteRepository;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    private ?Eleve $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    private ?Matiere $Matiere = null;

    #[ORM\Column(length: 255)]
    private ?string $typeEvaluation = null;

    #[ORM\Column]
    private ?float $note = null;

    #[ORM\Column]
    private ?int $Trimestre = null;

    #[ORM\Column]
    private ?int $Coefficient = null;

    #[ORM\Column(length: 255)]
    private ?string $Mention = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateMiseajour = null;

    public function __construct()
    {
        $this->date = new DateTime();
        $this->dateMiseajour = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->Matiere;
    }

    public function setMatiere(?Matiere $Matiere): static
    {
        $this->Matiere = $Matiere;

        return $this;
    }

    public function getTypeEvaluation(): ?string
    {
        return $this->typeEvaluation;
    }

    public function setTypeEvaluation(string $typeEvaluation): static
    {
        $this->typeEvaluation = $typeEvaluation;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getTrimestre(): ?int
    {
        return $this->Trimestre;
    }

    public function setTrimestre(int $Trimestre): static
    {
        $this->Trimestre = $Trimestre;

        return $this;
    }

    public function getCoefficient(): ?int
    {
        return $this->Coefficient;
    }

    public function setCoefficient(int $Coefficient): static
    {
        $this->Coefficient = $Coefficient;

        return $this;
    }

    public function getMention(): ?string
    {
        return $this->Mention;
    }

    public function setMention(string $Mention): static
    {
        $this->Mention = $Mention;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDateMiseajour(): ?\DateTimeInterface
    {
        return $this->dateMiseajour;
    }

    public function setDateMiseajour(\DateTimeInterface $dateMiseajour): static
    {
        $this->dateMiseajour = $dateMiseajour;

        return $this;
    }
}
