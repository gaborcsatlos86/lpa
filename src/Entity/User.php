<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;


#[ORM\Entity]
#[ORM\UniqueConstraint(name: "username", columns: ["username"])]
class User extends BaseUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id;
    
    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected ?string $level = null;
    
    #[ORM\Column(type: Types::STRING, nullable: true)]
    protected ?string $area = null;
    
    public function getLevel(): ?string
    {
        return $this->level;
    }
    
    public function setLevel(?string $level): self
    {
        $this->level = $level;
        
        return $this;
    }
    
    public function getArea(): ?string
    {
        return $this->area;
    }
    
    public function setArea(?string $area): self
    {
        $this->area = $area;
        
        return $this;
    }
    
}
