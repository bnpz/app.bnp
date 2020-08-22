<?php

namespace App\Form\General\Event;

use App\Entity\General\Event;
use App\Service\General\EventService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFiltersType extends AbstractType
{
    private $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Form is submited from: public/assets/js/custom.js
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $filters = $this->eventService->getFiltersFromSession();
        if(isset($filters['premiere'])){
            $premiereValue = (bool)$filters['premiere'];
        }
        else{
            $premiereValue = false;
        }
        if(isset($filters['externalProduction'])){
            $externalProductionValue = (bool)$filters['externalProduction'];
        }
        else{
            $externalProductionValue = false;
        }
        if(isset($filters['homeProduction'])){
            $homeProductionValue = (bool)$filters['homeProduction'];
        }
        else{
            $homeProductionValue = false;
        }

        $builder
            ->add('premiere', null, [
                'label' => "entityField.premiere",
                'data' => $premiereValue

            ])
            ->add('homeProduction', CheckboxType::class, [
                'label' => "entityField.homeProduction",
                'data' => $homeProductionValue,
                'required' => false
            ])
            ->add('externalProduction', null, [
                'label' => "entityField.externalProduction",
                'data' => $externalProductionValue
            ])
           /* ->add('submit', SubmitType::class, [
                'attr' => [
                    'hidden' => false,
                    'class' => 'btn btn-outline-info'
                ],
                'label' => 'label.submit'

            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}