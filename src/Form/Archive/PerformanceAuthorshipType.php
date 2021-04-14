<?php
namespace App\Form\Archive;

use App\Entity\Archive\Authorship;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PerformanceAuthorshipType
 * @package App\Form\Archive
 */
class PerformanceAuthorshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('performance', null, [
                'label' => "label.performance",
                'disabled' => true
            ])
            ->add('authorshipType', null, [
                'label' => "label.authorship",
                'placeholder' => 'label.choose',
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('authorshipType')
                        ->orderBy('authorshipType.name', 'ASC');
                }
            ])
            ->add('author', null, [
                'label' => "label.author",
                'placeholder' => 'label.choose',
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('author')
                        ->orderBy('author.firstName', 'ASC');
                }
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Authorship::class,
        ]);
    }
}