<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\User;
use App\Form\QuizType;
use App\Repository\QuizRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quiz")
 */
class QuizController extends Controller
{
    /**
     * @Route("/", name="quiz_index", methods="GET")
     *
     */
    public function index(QuizRepository $quizRepository): Response
    {
        return $this->render('quiz/index.html.twig', ['quizzes' => $quizRepository->findBy([
            'author' => $this->getUser()
        ])]);
    }

    /**
     * @Route("/new", name="quiz_new", methods="GET|POST")
     * @Security("has_role('ROLE_TEACHER')")
     */
    public function new(Request $request): Response
    {
        $quiz = new Quiz();

        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find(1);
            $em = $this->getDoctrine()->getManager();
            $quiz->setAuthor($user);
            $em->persist($user);
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute('question_new',[
                'quizId' => $quiz->getId()
            ]);
        }

        return $this->render('quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quiz_show", methods="GET")
     */
    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', ['quiz' => $quiz]);
    }

    /**
     * @Route("/{id}/edit", name="quiz_edit", methods="GET|POST")
     */
    public function edit(Request $request, Quiz $quiz): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quiz_edit', ['id' => $quiz->getId()]);
        }

        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quiz_delete", methods="DELETE")
     */
    public function delete(Request $request, Quiz $quiz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($quiz);
            $em->flush();
        }

        return $this->redirectToRoute('quiz_index');
    }
}
