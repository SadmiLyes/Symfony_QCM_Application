<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('birthday', BirthdayType::class, array(
                'label' => 'Date of Birth',
                'years' => range(1893, date('Y'))
            ))
            ->add('address',TextType::class)
            ->add('email')
            ->add('password',PasswordType::class)
            ->add('gender',ChoiceType::class, array(
                'choices'  => array(
                    'Men' => "men",
                    'Women' => "women",
                ),
            ))
            ->add('role',ChoiceType::class, array(
                'choices'  => array(
                    'Teacher' => "TEACHER",
                    'Student' => "STUDENT",
                ),

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
