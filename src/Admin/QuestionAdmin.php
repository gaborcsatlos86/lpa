<?php

declare(strict_types=1);

namespace App\Admin;

use App\Enums\{Area, AnswerTypes, UserLevel};
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\StringListFilter;
use Symfony\Component\Form\Extension\Core\Type\{TextareaType, CheckboxType, ChoiceType};

final class QuestionAdmin extends AbstractAdmin
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
            ->with('general', ['class' => 'col-md-6'])
                ->add('text', TextareaType::class)
                ->add('active', CheckboxType::class)
            ->end()
            ->with('lpa', ['class' => 'col-md-4'])
                ->add('area',ChoiceType::class, [
                    'choices' => Area::getItems()
                ])
                ->add('level',ChoiceType::class, [
                    'choices' => UserLevel::getItems()
                ])
                ->add('availableAnswers',ChoiceType::class, [
                    'choices' => AnswerTypes::getItems(),
                    'multiple' => true,
                    'expanded' => true,
                    'data' => (!$this->hasSubject() || null === $this->getSubject()->getId()) ? AnswerTypes::getItems() : $this->getSubject()->getAvailableAnswers()
                ])
            ->end()
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('text')
            ->add('area', StringListFilter::class, [
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => Area::getItems(),
                    'multiple' => true
                ]
            ])
            ->add('level', StringListFilter::class, [
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => UserLevel::getItems(),
                    'multiple' => true
                ]
            ])
            ->add('active')
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('text')
            ->add('area', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('level', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('availableAnswers', FieldDescriptionInterface::TYPE_ARRAY)
            ->add('active', null, ['editable' => true])
            
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('text')
            ->add('area', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('level', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('availableAnswers', FieldDescriptionInterface::TYPE_ARRAY)
            ->add('active')
        ;
    }
}
