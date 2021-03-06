<?php

namespace App\Form\General\Event;

use App\Entity\General\Event;
use App\Repository\General\EventTypeRepository;
use App\Service\General\EventService;
use App\Service\General\EventTypeService;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventFiltersType
 * @package App\Form\General\Event
 */
class EventFiltersType extends AbstractType
{
    /**
     * @var EventService
     */
    private $eventService;
    /**
     * @var EventTypeService
     */
    private $eventTypeService;

    /**
     * EventFiltersType constructor.
     * @param EventService $eventService
     * @param EventTypeService $eventTypeService
     */
    public function __construct(EventService $eventService, EventTypeService $eventTypeService)
    {
        $this->eventService = $eventService;
        $this->eventTypeService = $eventTypeService;
    }

    /**
     * Form is submited from: public/assets/js/custom.js
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws Exception
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
        if(isset($filters['canceled'])){
            $canceledValue = (bool)$filters['canceled'];
        }
        else{
            $canceledValue = false;
        }
        if(isset($filters['guesting'])) {
            $guestingValue = true;
        }
        else {
            $guestingValue = false;
        }
        if(isset($filters['festival'])) {
            $festivalValue = true;
        }
        else {
            $festivalValue = false;
        }
        if(isset($filters['forAdults'])) {
            $forAdultsValue = true;
        }
        else {
            $forAdultsValue = false;
        }
        if(isset($filters['forChildren'])) {
            $forChildrenValue = true;
        }
        else {
            $forChildrenValue = false;
        }
        $eventTypeValue = null;
        if(isset($filters['eventType'])) {
            $eventTypeValue = $filters['eventType'];
        }

        $builder
            ->add('fromDate', DateType::class, [
                'label' => "label.from",
                'widget' => 'single_text',
                'html5' => true,
                'empty_data'  => null,
                'required' => false,
                'data' => isset($filters['fromDate']) ? new DateTime($filters['fromDate']) : null,
                'attr' => [
                    'class' => 'date-max-width'
                ],
            ])
            ->add('toDate', DateType::class, [
                'label' => "label.to",
                'widget' => 'single_text',
                'html5' => true,
                'empty_data'  => null,
                'required' => false,
                'data' => isset($filters['toDate']) ? new DateTime($filters['toDate']) : null,
                'attr' => [
                    'class' => 'date-max-width'
                ],
            ])
            ->add('eventType', null, [
                'required' => false,
                'label' => "entityField.eventType",
                //'placeholder' => '--',
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('entity')
                        ->orderBy('entity.id', 'ASC');
                },
                'data' => $eventTypeValue ? $this->eventTypeService->get($eventTypeValue) : null

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
            ->add('forAdults', null, [
                'label' => "entityField.forAdults",
                'data' => $forAdultsValue
            ])
            ->add('forChildren', null, [
                'label' => "entityField.forChildren",
                'data' => $forChildrenValue
            ])
            ->add('premiere', null, [
                'label' => "entityField.premiere",
                'data' => $premiereValue
            ])
            ->add('guesting', null, [
                'label' => "entityField.guesting",
                'data' => $guestingValue
            ])
            ->add('festival', null, [
                'label' => "entityField.festival",
                'data' => $festivalValue
            ])
            ->add('canceled', null, [
                'label' => "entityField.canceled",
                'data' => $canceledValue
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'hidden' => false,
                    'class' => 'btn bt-lg btn-bnp btn-info'
                ],
                'label' => 'label.applyFilters'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}