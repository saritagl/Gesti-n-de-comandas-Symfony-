<?php

namespace AppBundle\Form\Table;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TableEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, array('label' => 'Número'))
            ->add('chairNumber', null, array('label' => 'Sillas'))
            ->add('isAvailable', ChoiceType::class, array(
                'choices'  => array(
                    'Sí' => True,
                    'No' => False,
                ),
                'label' => 'Disponible',
            ))
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
            'data_class' => 'AppBundle\Entity\Table'
        ));
    }
}
