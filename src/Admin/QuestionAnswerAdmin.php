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
use Symfony\Component\Form\Extension\Core\Type\{TextareaType, ChoiceType};

final class QuestionAnswerAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('batch')
            ->remove('delete')
        ;
    }
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('general', ['class' => 'col-md-6'])
                ->add('user')
                ->add('level',ChoiceType::class, [
                    'choices' => array_merge(UserLevel::getItems(), ['---' => null])
                ])
                ->add('area',ChoiceType::class, [
                    'choices' => array_merge(Area::getItems(), ['---' => null])
                ])
                ->add('tableGroup')
                ->add('product')
            ->end()
            ->with('lpa', ['class' => 'col-md-4'])
                ->add('question')
                ->add('answer', ChoiceType::class, [
                    'choices' => AnswerTypes::getItems(),
                ])
                ->add('answerDescription', TextareaType::class)
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
            ->add('active')
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('text')
            ->add('area', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('level', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('answers', FieldDescriptionInterface::TYPE_TRANS)
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('text')
            ->add('area', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('availableAnswers', FieldDescriptionInterface::TYPE_ARRAY)
            ->add('active')
        ;
    }
}