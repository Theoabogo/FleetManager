<?php

namespace App\Controller;

use App\Entity\Assignment;
use App\Entity\Vehicle;
use App\Form\AssignmentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



final class AssignmentController extends AbstractController
{
    #[Route('/assignment/add', name: 'app_assignment_add')]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $assignment = new Assignment();

        $form = $this->createForm(AssignmentType::class, $assignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $assignment->getVehicle();

            $entityManager->persist($assignment);
            $entityManager->flush();

            return $this->redirectToRoute('app_assignment_list_assign');
        }

        return $this->render('assignment/add.html.twig', [
            'formView' => $form->createView(),
        ]);
    }

    #[Route('/assignment/list_assign', name: 'app_assignment_list_assign')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $assignments = $entityManager
            ->getRepository(Assignment::class)
            ->findAll();

        return $this->render('assignment/list_assign.html.twig', [
            'assignments' => $assignments,
        ]);
    }

    #[Route('/assignment/{id}/return', name: 'app_assignment_return',  methods: ['POST'])]
    public function returnVehicle(
        Assignment $assignment,
        EntityManagerInterface $entityManager, Request $request
    ): Response {
        if (!$this->isCsrfTokenValid('return'.$assignment->getId(), $request->request->get('_token'))) {
        throw $this->createAccessDeniedException('Invalid CSRF token');
    }
        $assignment->setReturnedAt(new \DateTime());

        $entityManager->flush();

       return $this->redirectToRoute('app_vehicle_show', [
    'id' => $assignment->getvehicle()->getId(),
]);
    }
}