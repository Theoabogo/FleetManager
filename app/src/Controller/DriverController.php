<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DriverRepository;

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
}
