<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\Suggestion;
use App\Form\QuestionType;
use App\Form\SuggestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question")
 */
class QuestionController extends Controller
{
    /**
     * @Route("/", name="question_index", methods="GET")
     */
    public function index(QuestionRepository $questionRepository): Response
    {
        return $this->render('question/index.html.twig', ['questions' => $questionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="question_new", methods="GET|POST")
     *
     */
    public function new(Request $request): Response
    {
        $question = new Question();
        $suggestion = new Suggestion();
        $form = $this->createForm(QuestionType::class, $question, ['attr' => ['id' => 'saveQuestion']]);
        $suggestionForm = $this->createForm(SuggestionType::class, $suggestion, ['attr' => ['id' => 'suggestionForm']]);

        $form->handleRequest($request);
        $quizId = $request->query->get('quizId');
        if ($quizId) {
            $quiz = $this->getDoctrine()
                ->getRepository(Quiz::class)
                ->find($quizId);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $question->setQuiz($quiz);
            $em->persist($quiz);
            $em->persist($question);
            $em->flush();
            return $this->json([
                'Id' => $question->getId(),
                'Enunciate' => $question->getEnunciate(),
                'isMultiple' => $question->getIsMultiple(),
                'quiz' => $question->getQuiz()->getId()
            ]);
        }

        return $this->render('question/new.html.twig', [
            'questions' => $quiz->getQuestions()->getValues(),
            'form' => $form->createView(),
            'suggestionForm' => $suggestionForm->createView()
        ]);
    }


    /**
     * @Route("/{id}", name="question_show", methods="GET")
     */
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', ['question' => $question]);
    }

    /**
     * @Route("/{id}/edit", name="question_edit", methods="GET|POST")
     */
    public function edit(Request $request, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_edit', ['id' => $question->getId()]);
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="question_delete", methods="DELETE")
     */
    public function delete(Request $request, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush();
        }

        return $this->redirectToRoute('question_index');
    }
}
