<?php


namespace App\Controller;

use Doctrine\Common\Annotations\AnnotationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractController extends SymfonyAbstractController
{
    const FLASH_TYPE_SUCCESS    = "success";
    const FLASH_TYPE_ERROR      = "error";
    const FLASH_TYPE_NOTICE     = "notice";

    /**
     * @param string $message
     */
    protected function addFlashSuccess(string $message)
    {
        $this->addFlash(self::FLASH_TYPE_SUCCESS, $message);
    }

    /**
     * @param string $message
     */
    protected function addFlashError(string $message)
    {
        $this->addFlash(self::FLASH_TYPE_ERROR, $message);
    }

    /**
     * @param string $message
     */
    protected function addFlashNotice(string $message)
    {
        $this->addFlash(self::FLASH_TYPE_NOTICE, $message);
    }

    /**
     * @return object|Serializer
     */
    public function getSerializer()
    {
        return $this->get('serializer');
    }


    /**
     * @return Response
     */
    public function searchBar(): Response
    {
        $form = $this->createFormBuilder()
            ->add('query', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['minlength' => 3, 'placeholder' => "label.search"]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['hidden' => true]
            ])
            ->getForm();

        return $this->render('inc/search.form.html.twig', ['form' => $form->createView()]);
    }
}