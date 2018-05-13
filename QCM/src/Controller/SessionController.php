<?php
namespace App\Controller;
use App\Entity\ClassRoom;
use App\Entity\Quiz;
use App\Entity\ResultQcm;
use App\Entity\Session;
use App\Entity\Suggestion;
use App\Entity\User;
use App\Form\ExamType;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/session")
 */
class SessionController extends Controller
{
    /**
     * @Route("/", name="session_index", methods="GET")
     *
     */
    public function index(SessionRepository $sessionRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('session/index.html.twig', ['sessions' => $sessionRepository->findBy([
            'author' => $this->getUser()
        ])]);
    }
    /**
     * @Route("/new", name="session_new", methods="GET|POST")
     * Security("has_role('ROLE_TEACHER')")
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $session = new Session();
        $group = $this->getDoctrine()
            ->getRepository(ClassRoom::class)
            ->findBy([
                'author' => $this->getUser()
            ]);
        $user = $this->getUser();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $session->setAuthor($user);
            $em->persist($session);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="session_show", methods="GET")
     */
    public function show(Session $session): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('session/show.html.twig', ['session' => $session]);
    }
    /**
     * @Route("/{id}/edit", name="session_edit", methods="GET|POST")
     */
    public function edit(Request $request, Session $session): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('session_edit', ['id' => $session->getId()]);
        }
        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="session_delete", methods="DELETE")
     */
    public function delete(Request $request, Session $session): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($session);
            $em->flush();
        }
        return $this->redirectToRoute('session_index');
    }
    /**
     * @Route("/{id}/exam", name="session_exam", methods="GET|POST")
     */
    public function examAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $session = $this->getDoctrine()
            ->getRepository(Session::class)
            ->find($id);

        $resultQcmCheck = $this->getDoctrine()
            ->getRepository(ResultQcm::class)->findOneBy([
                'session' => $session->getId(),
            ]);

        if (!!$resultQcmCheck){
            $this->addFlash('error', 'You can\'t pass the session twice !');
            return $this->redirectToRoute('result_qcm_show', [
                'id' => $resultQcmCheck->getId()
            ]);
        }
        $user = $this->getUser();
        $resultQcm = new ResultQcm();
        $form = $this->createForm(ExamType::class, [
            'session' => $session
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $emResultQcm = $this->getDoctrine()->getManager();
            $answers = $form->getData();
            $session = array_splice($answers, 0, 1)['session'];
            $quiz = $session->getQuiz();
            $mark = $this->getFinalMark($this->getAverage($answers, $quiz), $quiz);
            $resultQcm->setQuiz($quiz);
            $resultQcm->setSession($session);
            $resultQcm->setStudent($user);
            $resultQcm->setMark($mark);
            $emResultQcm->persist($resultQcm);
            $emResultQcm->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('session/exam.html.twig', [
            'id' => $id,
            'form' => $form->createView()
        ]);
    }
    private function getPoint($id, $quiz)
    {
        $suggesstion = $this->getDoctrine()->getRepository(Suggestion::class)->find($id);
        $suggestions = $suggesstion->getQuestion()->getSuggestions()->getValues();
        $devider = 0;
        foreach ($suggestions as $item){
            if ($item->getAnswer()){
                $devider++;
            }
        }
        if ($devider > 0) {
            $plus = $quiz->getRightAmountPoints() / $devider;
        } else {
            $plus = $quiz->getRightAmountPoints();
        }
        if ($quiz) {
            switch (!!$suggesstion->getAnswer()) {
                case true :
                    return $plus;
                    break;
                case false:
                    return -$quiz->getWrongAmountPoints();
                    break;
            }
        }
    }
    private function getFinalMark($mark,$quiz)
    {
        if ($quiz){
           $maxPoint = $quiz->getQuestions()->count() * $quiz->getRightAmountPoints();
            return ceil(($mark / $maxPoint) * $quiz->getMaxPoints());
        }else {
            return false;
        }
    }
    private function getAverage($answers, $quiz, $mark = 0)
    {
        if ($quiz){
        foreach ($answers as $answer) {;
                if (is_array($answer) && count($answer) > 0) {
                    $mark = $this->getAverage($answer, $quiz, $mark);
                } else if((is_array($answer) && count($answer) === 0) || $answer === null) {
                    $mark += $quiz->getNeutralAmountPoints();
                } else {
                    $mark += $this->getPoint($answer,$quiz);
                }
            }
            return $mark < 0 ? 0 : $mark;
        } else {
            return false;
        }
    }
}
