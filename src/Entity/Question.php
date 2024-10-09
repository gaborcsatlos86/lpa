<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};


#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Question extends AbstractBaseEntity
{
    #[ORM\Column(type: Types::TEXT)]
    private string $text;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;
    
    #[ORM\Column(type: Types::STRING)]
    private string $area;
    
    #[ORM\Column(type: Types::STRING)]
    private string $level;
    
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active;
    
    #[ORM\Column(type: Types::JSON)]
    private array $availableAnswers = [];
    
    public function getText(): string
    {
        return $this->text;
    }
    
    public function setText(string $text): self
    {
        $this->text = $text;
        
        return $this;
    }
    
    public function getComment(): ?string
    {
        return $this->comment;
    }
    
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        
        return $this;
    }
    
    public function getArea(): string
    {
        return $this->area;
    }
    
    public function setArea(string $area): self
    {
        $this->area = $area;
        
        return $this;
    }
    
    public function getLevel(): string
    {
        return $this->level;
    }
    
    public function setLevel(string $level): self
    {
        $this->level = $level;
        
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
    
    public function getAvailableAnswers(): array
    {
        return $this->availableAnswers;
    }
    
    public function setAvailableAnswers(array $availableAnswers): self
    {
        $this->availableAnswers = $availableAnswers;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return substr($this->text, 0, 20);
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