<?php

declare(strict_types=1);

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\DoctrineORMAdminBundle\Filter\NullFilter;
use Sonata\AdminBundle\DependencyInjection\Admin\AbstractTaggedAdmin;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


final class StatementAdmin extends AbstractAdmin
{
    public function __construct(
        private ParameterBagInterface $params,
        ?string $code = null,
        ?string $class = null,
        ?string $baseControllerName = null
    ) {
        parent::__construct();
    }
    
    
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('show')
            ->remove('create')
            ->remove('edit')
            ->add('createMonthly')
            ->add('createYearly')
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('name')
            ->add('date')
            ->add('path')
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
            ->add('date')
            ->add('path', FieldDescriptionInterface::TYPE_STRING, [
                'template' => 'admin/list/list_link_field.html.twig'
            ])
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
    }
    
    protected function configureActionButtons(array $buttonList, string $action, ?object $object = null): array
    {
        $buttonList['createMonthly'] = ['template' => 'admin/list/monthly_button.html.twig'];
        $buttonList['createYearly'] = ['template' => 'admin/list/yearly_button.html.twig'];
        
        return $buttonList;
    }
    
    protected function configureDashboardActions(array $actions): array
    {
        $actions['createMonthly'] = [
            'label' => 'create_monthly_action',
            'translation_domain' => 'SonataAdminBundle',
            'url' => $this->generateUrl('createMonthly'),
            'icon' => 'fas fa-plus-circle',
        ];
        $actions['createYearly'] = [
            'label' => 'create_yearly_action',
            'translation_domain' => 'SonataAdminBundle',
            'url' => $this->generateUrl('createYearly'),
            'icon' => 'fas fa-plus-circle',
        ];
        
        return $actions;
    }
    
    protected function postRemove(object $object): void
    {
        $projectDir = $this->params->get('kernel.project_dir') . '/public';
        unlink($projectDir.$object->getPath());
    }
}