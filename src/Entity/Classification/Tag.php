<?php

declare(strict_types=1);

namespace App\Entity\Classification;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseTag;

#[ORM\Entity]
#[ORM\Table(name: 'classification__tag')]
class Tag extends BaseTag
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    protected ?int $id = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }
}