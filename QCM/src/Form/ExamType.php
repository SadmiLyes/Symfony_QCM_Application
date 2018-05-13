<?php
/**
 * Created by PhpStorm.
 * User: Lyes
 * Date: 5/11/2018
 * Time: 9:07 AM
 */

namespace App\Form;
use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $quiz = $options['data']['session']->getQuiz();
        if ($quiz){
            $questions = $quiz->getQuestions()->getValues();
            $i = 1;
            foreach ($questions as $question){
                $suggestions = $question->getSuggestions()->getValues();
                $choices = [];
                if (count($suggestions) > 0){
                    foreach ($suggestions as $suggestion) {
                        $choices[$suggestion->getContent()] = $suggestion->getId();
                    }
                }
                $builder
                    ->add('question-'. $i, ChoiceType::class, array(
                        'label' => $question->getEnunciate(),
                        'label_attr'=> [
                            'class' => 'form-group bg-light'
                        ],
                        'expanded' => true,
                        'multiple' => $question->getIsMultiple(),
                        'choices' => $choices
                    ));
                $i++;
            }

        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data' => null
        ]);
    }
}