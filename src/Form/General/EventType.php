<?php

namespace App\Form\General;

use App\Entity\General\Event;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $today = new DateTime();
        $currentYear = $today->format('Y');
        $today->modify('+2 years');
        $twoYearsAhead = $today->format('Y');

        $builder
            ->add('production', null, ['label' => "entityField.production"])
            ->add('name', null, ['label' => "entityField.eventName"])
            ->add('description', null, ['label' => "entityField.description"])
            ->add('time', DateTimeType::class,[
                'label' => 'entityField.time',
                'widget' => 'choice',
                'years' => range($currentYear, $twoYearsAhead)
            ])
            ->add('premiere', null, ['label' => "entityField.premiere"])
            ->add('externalProduction', null, ['label' => "entityField.externalProduction"])
            ->add('canceled', null, ['label' => "entityField.canceled"])
            ->add('note', null, ['label' => "entityField.note"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
