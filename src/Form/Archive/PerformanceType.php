<?php
namespace App\Form\Archive;

use App\Entity\Archive\Performance;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PerformanceType
 * @package App\Form\Archive
 */
class PerformanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $today = new DateTime();
        $month = date('m');
        if($month > 11){
            $today->modify('+1 years');
        }
        $currentYear = $today->format('Y');
        $startDate = new DateTime("1950-01-01");
        $startYear = $startDate->format("Y");
        $builder
            ->add('season', null, [
                'required' => true,
                'label' => "label.season",
                'placeholder' => '--',
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('entity')
                        ->orderBy('entity.id', 'DESC');
                }
            ])
            ->add('stage', null, [
                'required' => true,
                'label' => "label.stage",
                'placeholder' => '--',
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('entity')
                        ->orderBy('entity.id', 'ASC');
                }
            ])
            ->add('stageLabel', null, [
                'label' => "entityField.stageLabel",
                'help' => "entityField.stageLabelHelp"
            ])
            ->add('authorLabel', null, [
                'label' => "Autor(i)",
                'help' => "Opisni tekst autorstva"
            ])
            ->add('title', null, ['label' => "label.title", 'required' => true])
            ->add('premiereDate', DateType::class,[
                'required' => true,
                'label' => 'label.premiere',
                'widget' => 'choice',
                'years' => range($currentYear, $startYear)
            ])
            ->add('active', null, ['label' => "label.activePerformance"])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Performance::class,
        ]);
    }
}