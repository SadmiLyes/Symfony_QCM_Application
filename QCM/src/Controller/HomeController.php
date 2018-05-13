<?php
/**
 * Created by PhpStorm.
 * User: Lyes
 * Date: 5/6/2018
 * Time: 4:51 PM
 */

namespace App\Controller;


use App\Entity\ResultQcm;
use App\Repository\MemberRepository;
use App\Repository\QuizRepository;
use App\Repository\ResultQcmRepository;
use App\Repository\SessionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home", methods="GET")
     **/
    public function index(QuizRepository $quizRepository, ResultQcmRepository $resultQcmRepository, MemberRepository $memberRepository)
    {
        if ($this->getUser()){
            if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
                $params = [
                    'quizzes' => $quizRepository->findBy([
                        'author' => $this->getUser()
                    ])
                ];
            } else if ($this->get('security.authorization_checker')->isGranted('ROLE_STUDENT')){

                $a = $memberRepository->findBy([
                    'student' => $this->getUser()->getEmail()
                ]);
                $sessions = $this->array_flatten(array_filter(array_map(function($session){ return $session->getClassRoom()->getSessions()->getValues(); },$a), function ($item){ return $item; }));
                $params = [
                    'result_qcm' => $resultQcmRepository->findBy([
                        'student' => $this->getUser()
                    ]),
                    'sessions' => $sessions
                ];
            }
            return $this->render('home/index.html.twig', $params);
        } else {
            return $this->render('home/index.html.twig');
        }
    }

    private function array_flatten($array) {
        $return = array();
        foreach ($array as $key => $value) {
            if (is_array($value)){
                $return = array_merge($return, $this->array_flatten($value));
            } else {
                $return[$key] = $value;
            }
        }

        return $return;
    }
}