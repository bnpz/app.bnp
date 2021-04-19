<?php
namespace App\Form\Archive;

use App\Entity\Archive\Role;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PerformanceRoleType
 * @package App\Form\Archive
 */
class PerformanceRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('performance', null, [
                'label' => "label.performance",
                'disabled' => true,
                'required' => true
            ])
            ->add('name', null, [
                'label' => "entityField.roleName",
                'help' => "entityField.roleNameHelp"
            ])
            ->add('author', null, [
                'label' => "label.author",
                'placeholder' => "label.placeholder",
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('author')
                        ->orderBy('author.firstName', 'ASC');
                }
            ])
            ->add('authorLabel', null, [
                'label' => "entityField.authorLabel",
                'help' => "entityField.authorLabelHelp"
            ])
            ->add('positionInList', null, [
                'required' => true,
                'label' => "entityField.positionInList"
            ])
            ->add('changeInCasting', null, [
                'label' => "entityField.changeInCasting"
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}