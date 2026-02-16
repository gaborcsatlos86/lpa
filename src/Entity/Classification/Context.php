<?php

declare(strict_types=1);

namespace App\Entity\Classification;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseContext;

#[ORM\Entity]
#[ORM\Table(name: 'classification__context')]
class Context extends BaseContext
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    protected ?string $id = null;
}