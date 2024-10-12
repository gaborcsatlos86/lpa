<?php

declare(strict_types=1);

namespace App\Admin;

use App\Enums\{UserLevel};
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\StringListFilter;
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;
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
                ->add('tableGroup')
                ->add('product')
            ->end()
            ->with('lpa', ['class' => 'col-md-4'])
                ->add('question')
                ->add('answer')
                ->add('answerDescription', TextareaType::class)
            ->end()
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('user')
            ->add('level')
            ->add('area')
            ->add('question')
            ->add('answer')
            ->add('createdAt', DateRangeFilter::class)
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('user.username')
            ->add('area')
            ->add('level', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('product')
            ->add('question.externalId')
            ->add('question')
            ->add('answer', FieldDescriptionInterface::TYPE_TRANS)
            ->add('answerDescription')
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE)
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('user.username')
            ->add('area')
            ->add('level', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('product')
            ->add('question')
            ->add('answer', FieldDescriptionInterface::TYPE_TRANS)
            ->add('answerDescription')
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE)
        ;
    }
    
    protected function configureExportFields(): array
    {
        return ['user.username', 'area.name', 'level', 'product', 'question.externalId', 'question.text', 'answer', 'answerDescription', 'createdAt'];
    }
}
