<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $projectUser = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ProjectMilestone::class, orphanRemoval: true)]
    private Collection $milestones;

    public function __construct()
    {
        $this->milestones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectUser(): ?User
    {
        return $this->projectUser;
    }

    public function setProjectUser(?User $projectUser): self
    {
        $this->projectUser = $projectUser;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection<int, ProjectMilestone>
     */
    public function getMilestones(): Collection
    {
        return $this->milestones;
    }

    public function addMilestone(ProjectMilestone $milestone): self
    {
        if (!$this->milestones->contains($milestone)) {
            $this->milestones->add($milestone);
            $milestone->setProject($this);
        }

        return $this;
    }

    public function removeMilestone(ProjectMilestone $milestone): self
    {
        if ($this->milestones->removeElement($milestone)) {
            // set the owning side to null (unless already changed)
            if ($milestone->getProject() === $this) {
                $milestone->setProject(null);
            }
        }

        return $this;
    }
}
