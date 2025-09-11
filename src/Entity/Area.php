<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: "name", columns: ["name"])]
#[Gedmo\SoftDeleteable]
class Area extends AbstractBaseEntity
{
    use SoftDeleteable;
    
    #[ORM\Column(type: Types::STRING)]
    private string $name;
    
    #[ORM\ManyToOne(targetEntity: Area::class)]
    private ?Area $parent = null;
    
    #[ORM\Column(type: Types::STRING)]
    private string $type;

    #[ORM\Column(type: Types::STRING)]
    private string $externalId;
    
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active;
    
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    protected $deletedAt;
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getParent(): ?Area
    {
        return $this->parent;
    }
    
    public function setParent(?Area $parent): self
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
    
    public function setType(string $type): self
    {
        $this->type = $type;
        
        return $this;
    }
    
    public function getExternalId(): string
    {
        return $this->externalId;
    }
    
    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;
        
        return $this;
    }
    
    public function isActive(): bool
    {
        return $this->active;
    }
    
    public function setActive(bool $active): self
    {
        $this->active = $active;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->name;
    }
    
    #[ORM\PrePersist]
    public function onPrePersist(PrePersistEventArgs $eventArgs)
    {
        $this->onCreateSetTimes();
    }
    
    #[ORM\PreUpdate]
    public function onPreUpdate(PreUpdateEventArgs $eventArgs)
    {
        $this->onUpdateSetTime();
    }
    
}
