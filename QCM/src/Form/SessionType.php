<?php

namespace App\Form;

use App\Entity\ClassRoom;
use App\Entity\Quiz;
use App\Entity\Session;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = strstr(ltrim(strstr($_SESSION["_sf2_attributes"]["_security_main"],"id"),"id\";:"),";",true);

        $builder
            ->add('startDate', DateTimeType::class)
            ->add('endDate',DateTimeType::class)
        ;

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($user){
            $form = $event->getForm();
            $formOption = [
                'class' => Quiz::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('quiz')->select('quiz')->where('quiz.author = :author')->setParameter('author',$user);
                }
            ];
            $form->add('quiz',EntityType::class,$formOption);
        });

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($user){
            $form = $event->getForm();
            $formOption = [
                'class' => ClassRoom::class,
                'label' => 'Group',
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('class_room')->select('class_room')->where('class_room.author = :author')->setParameter('author',$user);
                },
                'choice_label' => 'name'
            ];

            $form->add('classRoom',EntityType::class,$formOption);
        });


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
            "allow_extra_fields" => true
        ]);
    }
}
