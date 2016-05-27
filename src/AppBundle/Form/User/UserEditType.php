<?php

namespace AppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array (
                'label' => 'Email'
            ))
            ->add('username', TextType::class, array(
                'label' => 'Username'
            ))
            ->add('roles', ChoiceType::class, array(
                'choices'  => array(
                    'User' => 'user',
                    'Server' => 'server',
                    'Admin' => 'admin',
                ),
                'multiple' => True,
                'expanded' => True,
                'label' => 'Roles',
            ))
            ->add('isActive', ChoiceType::class, array(
                'choices'  => array(
                    'Sí' => True,
                    'No' => False,
                ),
                'label' => 'Activo',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }
}
