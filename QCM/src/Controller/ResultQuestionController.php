<?php

namespace App\Controller;

use App\Entity\ResultQuestion;
use App\Form\ResultQuestionType;
use App\Repository\ResultQuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/result/question")
 */
class ResultQuestionController extends Controller
{
    /**
     * @Route("/", name="result_question_index", methods="GET")
     */
    public function index(ResultQuestionRepository $resultQuestionRepository): Response
    {
        return $this->render('result_question/index.html.twig', ['result_questions' => $resultQuestionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="result_question_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $resultQuestion = new ResultQuestion();
        $form = $this->createForm(ResultQuestionType::class, $resultQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resultQuestion);
            $em->flush();

            return $this->redirectToRoute('result_question_index');
        }

        return $this->render('result_question/new.html.twig', [
            'result_question' => $resultQuestion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="result_question_show", methods="GET")
     */
    public function show(ResultQuestion $resultQuestion): Response
    {
        return $this->render('result_question/show.html.twig', ['result_question' => $resultQuestion]);
    }

    /**
     * @Route("/{id}/edit", name="result_question_edit", methods="GET|POST")
     */
    public function edit(Request $request, ResultQuestion $resultQuestion): Response
    {
        $form = $this->createForm(ResultQuestionType::class, $resultQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('result_question_edit', ['id' => $resultQuestion->getId()]);
        }

        return $this->render('result_question/edit.html.twig', [
            'result_question' => $resultQuestion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="result_question_delete", methods="DELETE")
     */
    public function delete(Request $request, ResultQuestion $resultQuestion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resultQuestion->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resultQuestion);
            $em->flush();
        }

        return $this->redirectToRoute('result_question_index');
    }
}
