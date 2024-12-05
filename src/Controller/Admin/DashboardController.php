<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\Service;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $userCount = $entityManager->getRepository(User::class)->count([]);
        $bookingCount = $entityManager->getRepository(Booking::class)->count([]);
        $serviceCount = $entityManager->getRepository(Service::class)->count([]);
        
        $recentBookings = $entityManager->getRepository(Booking::class)
            ->findBy([], ['createdAt' => 'DESC'], 5);

        return $this->render('admin/dashboard/index.html.twig', [
            'user_count' => $userCount,
            'booking_count' => $bookingCount,
            'service_count' => $serviceCount,
            'recent_bookings' => $recentBookings,
        ]);
    }
}