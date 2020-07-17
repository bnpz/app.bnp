<?php

namespace App\Form\Test;

use App\Entity\Test\Nermin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NerminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company')
            ->add('name')
            ->add('email')
            ->add('phone')
            ->add('mobile')
            ->add('address')
            ->add('postNumber')
            ->add('city')
            ->add('country')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Nermin::class,
        ]);
    }
}
