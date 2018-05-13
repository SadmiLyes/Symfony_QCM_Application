<?php

namespace App\Form;

use App\Entity\ClassRoom;
use App\Entity\Member;
use App\Controller;
use App\Repository\ClassRoomRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;


class MemberType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = strstr(ltrim(strstr($_SESSION["_sf2_attributes"]["_security_main"],"id"),"id\";:"),";",true);
        $builder->add('student',TextType::class);
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($user) {
            $form = $event->getForm();
            $formOption = [
                'class' => ClassRoom::class,
                'query_builder' => function (ClassRoomRepository $classRoomRepository) use ($user) {
                    return $classRoomRepository->createQueryBuilder('class_room')->select('class_room')->where('class_room.author = :author')->setParameter('author',$user);
                },
                'choice_label' => 'name'
            ];
            $form->add('ClassRoom',EntityType::class, $formOption);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class
        ]);
    }
}
