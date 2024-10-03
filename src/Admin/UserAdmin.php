<?php


declare(strict_types=1);

namespace App\Admin;

use App\Enums\{UserLevel, Area};
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\UserBundle\Form\Type\RolesMatrixType;
use Symfony\Component\Form\Extension\Core\Type\{EmailType, PasswordType, ChoiceType};
use Sonata\DoctrineORMAdminBundle\Filter\StringListFilter;

class UserAdmin extends BaseUserAdmin
{
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('username')
            ->add('email')
            ->add('level')
            ->add('area', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
            ->add('enabled', null, ['editable' => true])
            ->add('createdAt');
        
        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $list
                ->add('impersonating', FieldDescriptionInterface::TYPE_STRING, [
                    'virtual_field' => true,
                    'template' => '@SonataUser/Admin/Field/impersonating.html.twig',
                ]);
        }
        
        $list->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
            'translation_domain' => 'SonataAdminBundle',
            'actions' => [
                'edit' => [],
            ],
        ]);
    }
    
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('level', StringListFilter::class, [
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => UserLevel::getItems(),
                    'multiple' => true
                ]
            ])
            ->add('area', StringListFilter::class, [
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => Area::getItems(),
                    'multiple' => true
                ]
            ])
        ;
    }
    
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('username')
            ->add('email')
            ->add('level')
            ->add('area', FieldDescriptionInterface::TYPE_TRANS, ['translation_domain' => 'messages'])
        ;
    }
    
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('general', ['class' => 'col-md-4'])
                ->add('username')
                ->add('email', EmailType::class, ['required' => false, 'data' => 'no-email@lpa.local'])
                ->add('plainPassword', PasswordType::class, [
                    'required' => (!$this->hasSubject() || null === $this->getSubject()->getId()),
                ])
                ->add('enabled', null)
            ->end()
            ->with('lpa', ['class' => 'col-md-4'])
                ->add('level',ChoiceType::class, [
                    'choices' => array_merge(UserLevel::getItems(), ['---' => null])
                ])
                ->add('area',ChoiceType::class, [
                    'choices' => array_merge(Area::getItems(), ['---' => null])
                ])
            ->end()
            ->with('roles', ['class' => 'col-md-4'])
                ->add('realRoles', RolesMatrixType::class, [
                    'label' => false,
                    'multiple' => true,
                    'required' => false,
                ])
            ->end();
    }
}