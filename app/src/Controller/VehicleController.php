<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\DriverRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Assignment;

final class VehicleController extends AbstractController
{
  #[Route('/', name: 'app_dashboard')]
public function index(
    VehicleRepository $vehicleRepository,
    DriverRepository $driverRepository,
    EntityManagerInterface $entityManager
): Response {
    $totalVehicles = $vehicleRepository->count([]);
    $totalDrivers = $driverRepository->count([]);

    $available = 0;

    foreach ($vehicleRepository->findAll() as $vehicle) {
        if (
            $vehicle->getStatus() === Vehicle::STATUS_FREE
            && !$vehicle->getActiveAssignment()
        ) {
            $available++;
        }
    }

    $maintenance = $vehicleRepository->count([
        'status' => Vehicle::STATUS_MAINTENANCE,
    ]);

    $outOfService = $vehicleRepository->count([
        'status' => Vehicle::STATUS_OUT_OF_SERVICE,
    ]);

    $assigned = $entityManager
        ->getRepository(Assignment::class)
        ->count([
            'returnedAt' => null,
        ]);

    return $this->render('vehicle/index.html.twig', [
        'totalVehicles' => $totalVehicles,
        'totalDrivers' => $totalDrivers,
        'available' => $available,
        'maintenance' => $maintenance,
        'outOfService' => $outOfService,
        'totalAssigned' => $assigned,
    ]);
}

    

    #[Route('/vehicle/add_vehicle', name: 'app_vehicle_add_vehicle')]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
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

    #[Route('/vehicles', name: 'app_List_Vehicles')]
public function list(
    VehicleRepository $vehicleRepository,
    DriverRepository $driverRepository,
    EntityManagerInterface $entityManager
): Response {
    $vehicles = $vehicleRepository->findAll();

    $totalVehicles = $vehicleRepository->count([]);
    $totalDrivers = $driverRepository->count([]);

    $available = 0;

    foreach ($vehicles as $vehicle) {
        if (
            $vehicle->getStatus() === Vehicle::STATUS_FREE
            && !$vehicle->getActiveAssignment()
        ) {
            $available++;
        }
    }

    $maintenance = $vehicleRepository->count([
        'status' => Vehicle::STATUS_MAINTENANCE,
    ]);

    $outOfService = $vehicleRepository->count([
        'status' => Vehicle::STATUS_OUT_OF_SERVICE,
    ]);

    $assigned = $entityManager
        ->getRepository(Assignment::class)
        ->count([
            'returnedAt' => null,
        ]);

    return $this->render('vehicle/list.html.twig', [
        'vehicles' => $vehicles,
        'totalVehicles' => $totalVehicles,
        'totalDrivers' => $totalDrivers,
        'totalEmprunts' => $assigned,
        'available' => $available,
        'maintenance' => $maintenance,
        'outOfService' => $outOfService,
    ]);
}

    #[Route('/vehicle/{id}', name: 'app_vehicle_show')]
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicle,
            'activeAssignment' => $vehicle->getActiveAssignment(),
        ]);
    }

    #[Route('/vehicle/{id}/edit', name: 'app_vehicle_edit')]
    public function edit(
        Request $request,
        Vehicle $vehicle,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setStatus($vehicle->getStatus());
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicle_show', [
                'id' => $vehicle->getId(),
            ]);
        }

        return $this->render('vehicle/add_vehicle.html.twig', [
            'formView' => $form->createView(),
            'vehicle' => $vehicle,
        ]);
    }

    #[Route('/vehicle/{id}/out_of_service', name: 'app_vehicle_out_of_service')]
    public function outOfService(
        Vehicle $vehicle,
        EntityManagerInterface $entityManager
    ): Response {
        if ($vehicle->getActiveAssignment()) {
            $this->addFlash(
                'danger',
                'Impossible de mettre hors service un véhicule actuellement en mission.'
            );

            return $this->redirectToRoute('app_vehicle_show', [
                'id' => $vehicle->getId(),
            ]);
        }

        $vehicle->setStatus(Vehicle::STATUS_OUT_OF_SERVICE);

        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le véhicule a été mis hors service.'
        );

        return $this->redirectToRoute('app_vehicle_show', [
            'id' => $vehicle->getId(),
        ]);
    }
}