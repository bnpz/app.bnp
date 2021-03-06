<?php

namespace App\Form\General;

use App\Entity\General\Event;
use DateTime;
use Doctrine\ORM\EntityRepository;
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
            ->add('eventType', null, [
                'required' => true,
                'label' => "entityField.eventType",
                'placeholder' => '--',
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('entity')
                        ->orderBy('entity.id', 'ASC');
                }
            ])
            ->add('production', null, ['label' => "entityField.production"])
            ->add('name', null, ['label' => "entityField.eventName"])
            ->add('description', null, ['label' => "entityField.description"])
            ->add('time', DateTimeType::class,[
                'label' => 'entityField.time',
                'widget' => 'choice',
                'years' => range($currentYear, $twoYearsAhead)
            ])
            ->add('forAdults', null, ['label' => "entityField.forAdults"])
            ->add('forChildren', null, ['label' => "entityField.forChildren"])
            ->add('premiere', null, ['label' => "entityField.premiere"])
            ->add('externalProduction', null, ['label' => "entityField.externalProduction"])
            ->add('canceled', null, ['label' => "entityField.canceled"])
            ->add('guestingTitle', null, ['label' => "entityField.guestingTitle"])
            ->add('festivalTitle', null, ['label' => "entityField.festivalTitle"])
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
