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
class TableGroup extends AbstractBaseEntity
{
    use SoftDeleteable;
    
    #[ORM\Column(type: Types::STRING)]
    private string $name;
    
    #[ORM\Column(type: Types::STRING)]
    private string $code;
    
    #[ORM\ManyToOne(targetEntity: Area::class)]
    private Area $area;
    
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    protected $deletedAt;
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getCode(): string
    {
        return $this->code;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function setCode(string $code): self
    {
        $this->code = $code;
        
        return $this;
    }
    
    public function getArea(): Area
    {
        return $this->area;
    }
    
    public function setArea(Area $area): self
    {
        $this->area = $area;
        
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
