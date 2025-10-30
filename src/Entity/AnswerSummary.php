<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};
use \DateTimeImmutable;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class AnswerSummary extends AbstractBaseEntity
{
    #[ORM\Column(type: Types::STRING)]
    private string $level;
    
    #[ORM\ManyToOne(targetEntity: Area::class)]
    private ?Area $area = null;
    
    #[ORM\ManyToOne(targetEntity: TableGroup::class)]
    private ?TableGroup $tableGroup = null;
    
    #[ORM\Column(type: Types::STRING)]
    private string $product;
    
    #[ORM\Column(type: Types::STRING)]
    private string $answer;
    
    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $corrNum = 0;
    
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private DateTimeImmutable $periodStart;
    
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $periodEnd = null;
        
    
    public function getLevel(): string
    {
        return $this->level;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function getTableGroup(): ?TableGroup
    {
        return $this->tableGroup;
    }

    public function getProduct(): string
    {
        return $this->product;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }
    
    public function getCorrNum(): int
    {
        return $this->corrNum;
    }
    
    public function getPeriodStart(): DateTimeImmutable
    {
        return $this->periodStart;
    }
    
    public function getPeriodEnd(): ?DateTimeImmutable
    {
        return $this->periodEnd;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;
        
        return $this;
    }

    public function setArea(?Area $area = null): self
    {
        $this->area = $area;
        
        return $this;
    }

    public function setTableGroup(?TableGroup $tableGroup = null): self
    {
        $this->tableGroup = $tableGroup;
        
        return $this;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;
        
        return $this;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;
        
        return $this;
    }
    
    public function setCorrNum(int $corrNum): self
    {
        $this->corrNum = $corrNum;
        
        return $this;
    }
    
    public function increaseCorrNum(): self
    {
        $this->corrNum++;
        
        return $this;
    }
    
    public function setPeriodStart(DateTimeImmutable $periodStart): self
    {
        $this->periodStart = $periodStart;
        
        return $this;
    }
    
    public function setPeriodEnd(?DateTimeImmutable $periodEnd = null): self
    {
        $this->periodEnd = $periodEnd;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return (($this->area instanceof Area) ? $this->area->getName() : '') . ' ('. $this->level . ') ' . $this->product. ': ' . $this->answer . ' ['. $this->periodStart->format('Y-m-d') . (($this->periodEnd instanceof DateTimeImmutable ) ? ' - '. $this->periodEnd->format('m-d') : '').  ']';
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