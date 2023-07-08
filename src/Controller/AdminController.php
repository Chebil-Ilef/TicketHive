<?php

namespace App\Controller;

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\Feedback;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;



class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(ManagerRegistry $registry): Response
    {
        /*Total numbers of clients, events, tickets and feedback*/
        $entityManager = $registry->getManager();
        $clientCount = $entityManager->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(Client::class, 'u')
            ->where('u.username != :username')
            ->andWhere('u.email != :email')
            ->andWhere('u.password != :password')
            ->setParameter('username', 'admin')
            ->setParameter('email', 'admin@gmail.com')
            ->setParameter('password', 'admin')
            ->getQuery()
            ->getSingleScalarResult();
        $eventCount = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(Event::class, 'e')
            ->getQuery()
            ->getSingleScalarResult();
        $ticketCount = $entityManager->createQueryBuilder()
            ->select('COUNT(t.id)')
            ->from(Ticket::class, 't')
            ->getQuery()
            ->getSingleScalarResult();
        $testimonialCount = $entityManager->createQueryBuilder()
            ->select('COUNT(f.id)')
            ->from(Feedback::class, 'f')
            ->getQuery()
            ->getSingleScalarResult();

        /*Users to retrive infos to display in tabel*/
        // Retrieve all users except admin
        $users = $entityManager->createQueryBuilder()
            ->select('u')
            ->from(Client::class, 'u')
            ->where('u.username != :username')
            ->andWhere('u.email != :email')
            ->andWhere('u.password != :password')
            ->setParameter('username', 'admin')
            ->setParameter('email', 'admin@gmail.com')
            ->setParameter('password', 'admin')
            ->getQuery()
            ->getResult();

        /*working on the events chart*/
        // define the labels for the chart
        $eventLabels = ['Festivals', 'Sport', 'Concerts', 'Theatre', 'Cinema', 'Other'];

        $festivals = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(Event::class, 'e')
            ->where('e.event_type  = :EventType')
            ->setParameter('EventType', 'Festival')
            ->getQuery()
            ->getSingleScalarResult();
        $sport = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(Event::class, 'e')
            ->where('e.event_type  = :EventType')
            ->setParameter('EventType', 'Sport')
            ->getQuery()
            ->getSingleScalarResult();
        $concerts = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(Event::class, 'e')
            ->where('e.event_type  = :EventType')
            ->setParameter('EventType', 'Concert')
            ->getQuery()
            ->getSingleScalarResult();
        $theatre = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(Event::class, 'e')
            ->where('e.event_type  = :EventType')
            ->setParameter('EventType', 'Theatre')
            ->getQuery()
            ->getSingleScalarResult();
        $cinema = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(Event::class, 'e')
            ->where('e.event_type  = :EventType')
            ->setParameter('EventType', 'Cinema')
            ->getQuery()
            ->getSingleScalarResult();
        $other = $entityManager->createQueryBuilder()
            ->select('COUNT(e.id)')
            ->from(Event::class, 'e')
            ->where('e.event_type  = :EventType')
            ->setParameter('EventType', 'Other')
            ->getQuery()
            ->getSingleScalarResult();

        // define the data for the chart (this is just placeholder data)
        $eventData = [$festivals, $sport, $concerts, $theatre, $cinema, $other];

//        dd($eventData); debugged


        return $this->render('admin/index.html.twig', [
            'clientCount' => $clientCount,
            'eventCount' => $eventCount,
            'ticketCount' => $ticketCount,
            'testimonialCount' => $testimonialCount,
            'users' => $users,
            'eventLabels' => $eventLabels,
            'eventData' => $eventData,
        ]);
    }


    #[Route('/admin/user/{id}', name: 'delete_user')]

    public function deleteUser(Client $user, EntityManagerInterface $entityManager): Response
    {
        // Get related objects
        $tickets = $entityManager->createQueryBuilder()
            ->select('t')
            ->from(Ticket::class, 't')
            ->where('t.clientid = :clientid')
            ->setParameter('clientid', $user->getId())
            ->getQuery()
            ->getResult();
        $testimonials = $entityManager->createQueryBuilder()
            ->select('f')
            ->from(Feedback::class, 'f')
            ->where('f.clientid = :clientid')
            ->setParameter('clientid', $user->getId())
            ->getQuery()
            ->getResult();
        $events = $entityManager->createQueryBuilder()
            ->select('e')
            ->from(Event::class, 'e')
            ->where('e.clientid = :clientid')
            ->setParameter('clientid', $user->getId())
            ->getQuery()
            ->getResult();
        // Merge the related objects
        $relatedObjects = array_merge($tickets, $testimonials, $events);
        // Remove the related objects
        foreach ($relatedObjects as $relatedObject) {
            $entityManager->remove($relatedObject);
        }
        // Delete the main object
        $entityManager->remove($user);
        $entityManager->flush(); //commiting the changes to the database
        return $this->redirectToRoute('admin');
    }
}