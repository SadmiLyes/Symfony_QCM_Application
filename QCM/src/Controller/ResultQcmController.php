<?php

namespace App\Controller;

use App\Entity\ResultQcm;
use App\Form\ResultDetailsType;
use App\Form\ResultQcmType;
use App\Repository\ResultQcmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/result/qcm")
 */
class ResultQcmController extends Controller
{
    /**
     * @Route("/", name="result_qcm_index", methods="GET")
     */
    public function index(ResultQcmRepository $resultQcmRepository): Response
    {
        return $this->render('result_qcm/index.html.twig', ['result_qcms' => $resultQcmRepository->findAll()]);
    }

    /**
     * @Route("/new", name="result_qcm_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $resultQcm = new ResultQcm();
        $form = $this->createForm(ResultQcmType::class, $resultQcm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resultQcm);
            $em->flush();

            return $this->redirectToRoute('result_qcm_index');
        }

        return $this->render('result_qcm/new.html.twig', [
            'result_qcm' => $resultQcm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/details", name="result_qcm_details", methods="GET")
     */
    public function detailAction(ResultQcm $resultQcm): Response
    {
        return $this->render('result_qcm/details.html.twig', ['resultQcm' => $resultQcm]);
    }
    /**
     * @Route("/{id}", name="result_qcm_show", methods="GET")
     */
    public function show(ResultQcm $resultQcm): Response
    {
        return $this->render('result_qcm/show.html.twig', ['resultQcm' => $resultQcm]);
    }


    /**
     * @Route("/{id}/edit", name="result_qcm_edit", methods="GET|POST")
     */
    public function edit(Request $request, ResultQcm $resultQcm): Response
    {
        $form = $this->createForm(ResultQcmType::class, $resultQcm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('result_qcm_edit', ['id' => $resultQcm->getId()]);
        }

        return $this->render('result_qcm/edit.html.twig', [
            'result_qcm' => $resultQcm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="result_qcm_delete", methods="DELETE")
     */
    public function delete(Request $request, ResultQcm $resultQcm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resultQcm->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resultQcm);
            $em->flush();
        }

        return $this->redirectToRoute('result_qcm_index');
    }
}
