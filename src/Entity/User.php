<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;


#[ORM\Entity]
#[ORM\UniqueConstraint(name: "username", columns: ["username"])]
#[Gedmo\SoftDeleteable]
class User extends BaseUser
{
    use SoftDeleteable;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id;
    
    #[ORM\Column(type: Types::STRING)]
    protected string $name;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected ?string $level = null;
    
    #[ORM\ManyToOne(targetEntity: Area::class)]
    protected ?Area $area = null;
    
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
    
    public function getLevel(): ?string
    {
        return $this->level;
    }
    
    public function setLevel(?string $level): self
    {
        $this->level = $level;
        
        return $this;
    }
    
    public function getArea(): ?Area
    {
        return $this->area;
    }
    
    public function setArea(?Area $area): self
    {
        $this->area = $area;
        
        return $this;
    }
    
}
