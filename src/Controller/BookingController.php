<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/booking')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'app_booking_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $bookings = $entityManager
            ->getRepository(Booking::class)
            ->findBy(['user' => $this->getUser()], ['bookingDate' => 'DESC']);

        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    #[Route('/new/{id}', name: 'app_booking_new')]
    public function new(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $booking->setUser($this->getUser());
        $booking->setService($service);
        
        // Handle form submission logic here
        
        return $this->render('booking/new.html.twig', [
            'service' => $service,
        ]);
    }
}