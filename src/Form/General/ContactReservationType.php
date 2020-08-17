<?php
namespace App\Form\General;

use App\Entity\General\Reservation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventReservationType
 * @package App\Form\General
 */
class ContactReservationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('event', null, [
                'label' => "entityField.event",
                'placeholder' => 'label.choose',
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('event')
                        ->orderBy('event.name', 'asc');
                }
            ])
            ->add('contact', null, [
                'label' => "entityField.contact",
                'disabled' => true
            ])
            ->add('reserved', null, [
                'label' => "entityField.reserved"
            ])
            ->add('confirmed', null, [
                'label' => "entityField.confirmed"
            ])
            ->add('note', null, [
                'label' => "entityField.note"
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}