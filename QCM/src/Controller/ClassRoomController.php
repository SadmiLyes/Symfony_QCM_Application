<?php

namespace App\Controller;

use App\Entity\ClassRoom;
use App\Form\ClassRoomType;
use App\Repository\ClassRoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/class_room")
 */
class ClassRoomController extends Controller
{
    /**
     * @Route("/", name="class_room_index", methods="GET")
     */
    public function index(ClassRoomRepository $classRoomRepository): Response
    {
        dump($classRoomRepository);die;
        return $this->render('class_room/index.html.twig', ['class_rooms' => $classRoomRepository->findAll()]);
    }

    /**
     * @Route("/new", name="class_room_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $classRoom = new ClassRoom();
        $form = $this->createForm(ClassRoomType::class, $classRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classRoom);
            $em->flush();

            return $this->redirectToRoute('class_room_index');
        }

        return $this->render('class_room/new.html.twig', [
            'class_room' => $classRoom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="class_room_show", methods="GET")
     */
    public function show(ClassRoom $classRoom): Response
    {
        return $this->render('class_room/show.html.twig', ['class_room' => $classRoom]);
    }

    /**
     * @Route("/{id}/edit", name="class_room_edit", methods="GET|POST")
     */
    public function edit(Request $request, ClassRoom $classRoom): Response
    {
        $form = $this->createForm(ClassRoomType::class, $classRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('class_room_edit', ['id' => $classRoom->getId()]);
        }

        return $this->render('class_room/edit.html.twig', [
            'class_room' => $classRoom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="class_room_delete", methods="DELETE")
     */
    public function delete(Request $request, ClassRoom $classRoom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classRoom->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($classRoom);
            $em->flush();
        }

        return $this->redirectToRoute('class_room_index');
    }
}
