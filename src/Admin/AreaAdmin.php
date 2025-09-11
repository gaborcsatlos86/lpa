<?php

declare(strict_types=1);

namespace App\Admin;

use App\Enums\Area as AreaEnum;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\{StringListFilter, NullFilter};
use Symfony\Component\Form\Extension\Core\Type\{TextType, ChoiceType};

final class AreaAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name', TextType::class)
            ->add('parent')
            ->add('externalId')
            ->add('type',ChoiceType::class, [
                'choices' => AreaEnum::getItems()
            ])
            ->add('active')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('name')
            ->add('externalId')
            ->add('parent')
            ->add('active')
            ->add('type', StringListFilter::class, [
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => AreaEnum::getItems(),
                    'multiple' => true
                ]
            ])
            ->add('deleted', NullFilter::class, [
                'field_name' => 'deletedAt',
                'inverse' => true
            ])
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('name')
            ->add('externalId')
            ->add('parent')
            ->add('type')
            ->add('active')
            ->add('deletedAt')
        ;
        $list->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
            'translation_domain' => 'SonataAdminBundle',
            'actions' => [
                'delete' => [
                    'template' => 'admin/list/list_delete_action.html.twig'
                ],
            ],
        ]);
        $filters = $this->getModelManager()->getEntityManager($this->getClass())->getFilters();
        $filters->disable('soft_delete');
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('name')
            ->add('externalId')
            ->add('parent')
            ->add('type')
            ->add('active')
        ;
    }
}