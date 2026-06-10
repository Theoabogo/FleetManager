<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\VehicleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;






final class VehicleController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(VehicleRepository $vehicleRepository, DriverRepository $driverRepository): Response
    {
$totalVehicles = $vehicleRepository->count([]);
$totalDrivers = $driverRepository->count([]);

$available = $vehicleRepository->count(['status' => Vehicle::STATUS_FREE]);
$maintenance = $vehicleRepository->count(['status' => Vehicle::STATUS_MAINTENANCE]);
$outOfService = $vehicleRepository->count(['status' => Vehicle::STATUS_OUT_OF_SERVICE]);
$assigned = $vehicleRepository->count(['status' => Vehicle::STATUS_ASSIGNED]);

        return $this->render('vehicle/index.html.twig', [
            'totalVehicles' => $totalVehicles,
            'totalDrivers' => $totalDrivers,
            'available' => $available,
            'maintenance' => $maintenance,
            'outOfService' => $outOfService,
            'totalEmprunts' => $assigned,
        ]);
    }
    #[Route('/vehicles', name: 'app_List_Vehicles')]
    public function list(VehicleRepository $vehicleRepository, DriverRepository $driverRepository): Response
    {
        $vehicles = $vehicleRepository->findAll();
$totalVehicles = $vehicleRepository->count([]);
$totalDrivers = $driverRepository->count([]);

$available = $vehicleRepository->count(['status' => Vehicle::STATUS_FREE]);
$maintenance = $vehicleRepository->count(['status' => Vehicle::STATUS_MAINTENANCE]);
$outOfService = $vehicleRepository->count(['status' => Vehicle::STATUS_OUT_OF_SERVICE]);
$assigned = $vehicleRepository->count(['status' => Vehicle::STATUS_ASSIGNED]);
    return $this->render('vehicle/list.html.twig', [
            'vehicles' => $vehicles,
            'totalVehicles' => $totalVehicles,
            'totalEmprunts' => $assigned,
            'available' => $available,
            'maintenance' => $maintenance,
            'outOfService' => $outOfService,
        ]);
    }

    #[Route('/vehicle/add_vehicle', name: 'app_vehicle_add_vehicle')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setStatus(Vehicle::STATUS_FREE);
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->redirectToRoute('app_List_Vehicles');
        }

        return $this->render('vehicle/add_vehicle.html.twig', [
            'formView' => $form->createView(),
        ]);
    }
}
