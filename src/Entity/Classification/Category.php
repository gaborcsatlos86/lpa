<?php

declare(strict_types=1);

namespace App\Entity\Classification;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory;
use Sonata\ClassificationBundle\Model\CategoryInterface;

#[ORM\Entity]
#[ORM\Table(name: 'classification__category')]
class Category extends BaseCategory implements CategoryInterface
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    protected ?int $id = null;
    
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'children', cascade: ['persist', 'refresh', 'refresh', 'detach'])]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    protected ?CategoryInterface $parent = null;
    
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
}