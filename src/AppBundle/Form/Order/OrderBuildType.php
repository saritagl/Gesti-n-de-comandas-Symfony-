<?php

namespace AppBundle\Form\Order;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Product;

class OrderBuildType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, array(
                'class' => 'AppBundle:Product',
                'choice_label' => 'name',
                'choice_value' => 'name',
                'label' => 'Producto'))
            ->add('amount', null, array('label' => 'Cantidad'))
            ->add('addProduct', SubmitType::class, array(
                'label' => 'Agregar item',))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\OrderItem'
        ));
    }
}
