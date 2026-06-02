<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VehicleController extends AbstractController
{
    #[Route('/', name: 'app_vehicle')]
    public function index(VehicleRepository $vehicleRepository, DriverRepository $driverRepository): Response
    {
$totalVehicles = $vehicleRepository->count([]);
$totalDrivers = $driverRepository->count([]);

$available = $vehicleRepository->count(['status' => Vehicle::STATUS_FREE]);
$maintenance = $vehicleRepository->count(['status' => Vehicle::STATUS_MAINTENANCE]);
$outOfService = $vehicleRepository->count(['status' => Vehicle::STATUS_OUT_OF_SERVICE]);

        return $this->render('vehicle/index.html.twig', [
            'totalVehicles' => $totalVehicles,
            'totalDrivers' => $totalDrivers,
            'available' => $available,
            'maintenance' => $maintenance,
            'outOfService' => $outOfService,
        ]);
    }
}
