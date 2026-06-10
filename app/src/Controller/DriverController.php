<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DriverRepository;
use App\Form\DriverType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Driver;

final class DriverController extends AbstractController
{
    #[Route('/driver', name: 'app_List_Drivers')]
    public function index(DriverRepository $driverRepository): Response
    {
        $drivers = $driverRepository->findAll();

        return $this->render('driver/index.html.twig', [
            
            'drivers' => $drivers,
        ]);
    }
    #[Route('/driver/add_driver', name: 'driver_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $driver = new Driver;
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($driver);
            $entityManager->flush();

            return $this->redirectToRoute('app_List_Drivers');
        }

        return $this->render('driver/add_driver.html.twig', [
            'formView' => $form->createView()
        ]);
    }
}
