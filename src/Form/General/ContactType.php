<?php

namespace App\Form\General;

use App\Entity\General\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 * @package App\Form\General
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company',null, ['label' => "entityField.company"])
            ->add('firstName',null, ['label' => "entityField.firstName"])
            ->add('lastName',null, ['label' => "entityField.lastName"])
            ->add('email',null, ['label' => "entityField.email", 'required' => true])
            ->add('phone',null, ['label' => "entityField.phone"])
            ->add('mobile',null, ['label' => "entityField.mobile"])
            ->add('address',null, ['label' => "entityField.address"])
            ->add('postNumber',null, ['label' => "entityField.postNumber"])
            ->add('city',null, ['label' => "entityField.city"])
            ->add('country',null, ['label' => "entityField.country"])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
