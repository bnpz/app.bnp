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
                'disabled' => true,
                'required' => true
            ])
            ->add('authorshipType', null, [
                'required' => true,
                'label' => "label.authorship",
                'placeholder' => "label.placeholder",
                'empty_data'  => null,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('authorshipType')
                        ->orderBy('authorshipType.name', 'ASC');
                }
            ])
            ->add('authorshipTypeLabel', null, [
                'label' => "entityField.authorshipTypeLabel",
                'help' => "entityField.authorshipTypeLabelHelp"
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
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Authorship::class,
        ]);
    }
}