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
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\Form\Type\DatePickerType;

final class AnswerSummaryAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('batch')
            ->remove('delete')
        ;
        $collection->add('dataList');
    }
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('general', ['class' => 'col-md-6'])
                ->add('level',ChoiceType::class, [
                    'choices' => array_merge(UserLevel::getItems(), ['---' => null])
                ])
                ->add('area')
                ->add('tableGroup')
                ->add('product')
            ->end()
            ->with('lpa', ['class' => 'col-md-4'])
                ->add('answer')
                ->add('periodStart', DatePickerType::class)
                ->add('periodEnd', DatePickerType::class)
            ->end()
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('level')
            ->add('area')
            ->add('tableGroup')
            ->add('product')
            ->add('answer')
            ->add('periodStart', DateRangeFilter::class)
            ->add('periodEnd', DateRangeFilter::class)
            ->add('createdAt', DateRangeFilter::class)
        ;
    }
    
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('area')
            ->add('level', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('product')
            ->add('tableGroup')
            ->add('answer', FieldDescriptionInterface::TYPE_TRANS)
            ->add('periodStart', FieldDescriptionInterface::TYPE_DATE)
            ->add('periodEnd', FieldDescriptionInterface::TYPE_DATE)
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE)
        ;
        $filters = $this->getModelManager()->getEntityManager($this->getClass())->getFilters();
        $filters->disable('soft_delete');
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('area')
            ->add('level', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('product')
            ->add('tableGroup')
            ->add('answer', FieldDescriptionInterface::TYPE_TRANS)
            ->add('periodStart', FieldDescriptionInterface::TYPE_DATE)
            ->add('periodEnd', FieldDescriptionInterface::TYPE_DATE)
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE)
        ;
    }
    
    protected function configureExportFields(): array
    {
        return [ 'area.name', 'level', 'tableGroup', 'product', 'answer', 'periodStart', 'periodEnd', 'createdAt'];
    }
}
