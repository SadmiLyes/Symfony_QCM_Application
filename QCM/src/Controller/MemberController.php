<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/member")
 */
class MemberController extends Controller
{
    /**
     * @Route("/", name="member_index", methods="GET")
     */
    public function index(MemberRepository $memberRepository): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
          return $this->redirectToRoute('class_room_index');
        } 
        return $this->render('member/index.html.twig', ['members' => $memberRepository->findAll()]);
    }

    /**
     * @Route("/new", name="member_new", methods="GET|POST")
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
          return $this->redirectToRoute('class_room_index');
        } 
        $member = new Member();
        $form = $this->createForm(MemberType::class,$member);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $student_mail = $member->getStudent();
            $student_classroom = $member->getClassRoom();
            $check = $this->check_member($student_mail,$student_classroom);
            switch ($check) {
                case 0:
                    return $this->render('member/new.html.twig', [
                    'error' => "It's not a student",
                    'member' => $member,
                    'form' => $form->createView(),
                    ]);
                    break;
                case 1:
                    return $this->render('member/new.html.twig', [
                    'error' => "Student doesn't exist",
                    'member' => $member,
                    'form' => $form->createView(),
                     ]);
                    break;
                case 2:
                    return $this->render('member/new.html.twig', [
                        'error' => "Student has already been added to this group",
                        'member' => $member,
                        'form' => $form->createView(),
                    ]);
                    break;
                default:
                    break;
            }
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('rachidbensaid01@gmail.com')
                ->setTo($member->getStudent())
                ->setContentType("text/html")
                ->setBody(
                    $this->renderView(
                        'emails/confirmation.html.twig',
                    array(
                    'class' => $member->getClassRoom()->getName(),
                    'author' => $member->getClassRoom()->getAuthor()->getFirstName() . " ".$member->getClassRoom()->getAuthor()->getLastName(),
                    'link' => $member->getClassRoom()->getName()."_".$member->getClassRoom()->getId()."+".$member->getStudent()
                    ))
                )
            ;
            $mailer->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
            return $this->redirectToRoute('member_index');
        }

        return $this->render('member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    public function check_member($student_mail, $student_classroom)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
          return $this->redirectToRoute('class_room_index');
        } 
        $repository = $this
              ->getDoctrine()
              ->getManager()
              ->getRepository('App\Entity\User')
            ;
        $role = $repository->findOneBy(array('email' => $student_mail));
        if($repository->findOneBy(array('email' => $student_mail)) == null) {
            return 1;
        }
        if($role->getRoles()[0] !== "ROLE_STUDENT") {

            return 0;
        }
        
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('App\Entity\Member')
        ;
        
        if($repository->findOneBy(['student' => $student_mail,
                'classRoom' => $student_classroom,]) != null) {
            return 2;
        }
        return 3;
    }

    /**
     * @Route("/{id}", name="member_show", methods="GET")
     */
    public function show(Member $member): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
          return $this->redirectToRoute('class_room_index');
        } 
        return $this->render('member/show.html.twig', ['member' => $member]);
    }

    /**
     * @Route("/confirmation/{token}", name="member_confirmation", methods="GET")
     */
    public function confirmation($token)
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('App\Entity\Member')
        ;
        $mail = ltrim(strstr($token, '+'),"+");
        $group = strstr(ltrim(strstr($token, '_'),"_"),'+',true);
        $user = $repository->findOneBy(array('student' => $mail,
            'classRoom' => $group
            ));
        $user->setIsConfirmed(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('class_room_index');
    }

    /**
     * @Route("/{id}/edit", name="member_edit", methods="GET|POST")
     */
    public function edit(Request $request, Member $member): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
          return $this->redirectToRoute('class_room_index');
        }
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student_mail = $member->getStudent();
            $student_classroom = $member->getClassRoom();
            $check = $this->check_member($student_mail,$student_classroom);
            switch ($check) {
                case 0:
                    return $this->render('member/edit.html.twig', [
                    'error' => "It's not a student",
                    'member' => $member,
                    'form' => $form->createView(),
                    ]);
                    break;
                case 1:
                    return $this->render('member/edit.html.twig', [
                    'error' => "Student doesn't exist",
                    'member' => $member,
                    'form' => $form->createView(),
                     ]);
                    break;
                case 2:
                    return $this->render('member/edit.html.twig', [
                    'error' => "Student has already been added to this group",
                    'member' => $member,
                    'form' => $form->createView(),
                    ]);
                    break;
                default:
                    break;
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_edit', ['id' => $member->getId()]);
        }

        return $this->render('member/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_delete", methods="DELETE")
     */
    public function delete(Request $request, Member $member): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($member);
            $em->flush();
        }

        return $this->redirectToRoute('member_index');
    }
}
