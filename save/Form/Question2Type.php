<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class Question2Type extends AbstractType
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user =  2 /*$this->security->getUser()*/;
        $request = new Request();
        dump($request->get('id'));die;
        if (!$user) {
            throw new \LogicException(
                'The QuestionFormType cannot be used without an authenticated user!'
            );
        }

        $builder
            ->add('enunciate')
            ->add('isMultiple')
        ;
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($user){
            $form = $event->getForm();

            $formOption = [
                'class' => Quiz::class,
                'query_builder' => function (EntityRepository $entityRepository) use ($user) {
                    return $entityRepository->createQueryBuilder('quiz')->select('quiz')->where('quiz.author = :author')->setParameter('author',$user);
                }
            ];
            $form->add('quizId',EntityType::class,$formOption);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
