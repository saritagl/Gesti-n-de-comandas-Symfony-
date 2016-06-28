<?php

namespace AppBundle\Form\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\CallbackTransformer;


class ProductEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nombre'))
            ->add('price', null, array('label' => 'Precio'))
            ->add('description', null, array('label' => 'Descripción'))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label' => 'Categoría'))
            ->add('file', FileType::class, array(
                'data_class' => null,
                'label' => 'Image (jpeg, png)',
                'required' => false))
            ->add('save', SubmitType::class, array(
                'label' => 'Guardar cambios'))
            ->add('delete', SubmitType::class, array(
                'label' => 'Eliminar'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

}
