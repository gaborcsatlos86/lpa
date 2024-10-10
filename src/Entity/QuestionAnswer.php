<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class QuestionAnswer extends AbstractBaseEntity
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;
    
    #[ORM\Column(type: Types::STRING)]
    private string $level;
    
    #[ORM\ManyToOne(targetEntity: Area::class)]
    private Area $area;
    
    #[ORM\ManyToOne(targetEntity: TableGroup::class)]
    private TableGroup $tableGroup;
    
    #[ORM\ManyToOne(targetEntity: Product::class)]
    private Product $product;
    
    #[ORM\ManyToOne(targetEntity: Question::class)]
    private Question $question;
    
    #[ORM\Column(type: Types::STRING)]
    private string $answer;
    
    #[ORM\Column(type: Types::TEXT)]
    private ?string $answerDescription;
    
    public function getUser(): User
    {
        return $this->user;
    }
    
    public function getLevel(): string
    {
        return $this->level;
    }

    public function getArea(): Area
    {
        return $this->area;
    }

    public function getTableGroup(): TableGroup
    {
        return $this->tableGroup;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getAnswerDescription(): ?string
    {
        return $this->answerDescription;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        
        return $this;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;
        
        return $this;
    }

    public function setArea(Area $area): self
    {
        $this->area = $area;
        
        return $this;
    }

    public function setTableGroup(TableGroup $tableGroup): self
    {
        $this->tableGroup = $tableGroup;
        
        return $this;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        
        return $this;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;
        
        return $this;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;
        
        return $this;
    }

    public function setAnswerDescription(?string $answerDescription): self
    {
        $this->answerDescription = $answerDescription;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->answer . ' - ' . $this->question->getText();
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