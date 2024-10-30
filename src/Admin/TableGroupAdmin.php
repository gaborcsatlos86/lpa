<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\TableGroup;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Sonata\AdminBundle\Route\RouteCollectionInterface;


final class TableGroupAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
        ->remove('delete')
        ;
    }
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
        ->add('name', TextType::class)
        ->add('code', TextType::class)
        ->add('area')
        ;
    }
    
    protected function configureFormOptions(array &$formOptions): void
    {
        $formOptions['constraints'] = [
            new UniqueEntity([
                'entityClass' => TableGroup::class,
                'fields' => 'name',
            ]),
        ];
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
        ->add('name')
        ->add('code')
        ->add('area')
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
        ->addIdentifier('name')
        ->add('code')
        ->add('area')
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
        ->add('name')
        ->add('code')
        ->add('area')
        ;
    }
}