<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DescriptionController extends AbstractController
{
    #[Route('/eventDescription/{id}', name: 'event_description')]

    public function showEventAction(ManagerRegistry $doctrine,$id): Response
    {
        $repo = $doctrine->getRepository(Event::class);
        // événement à partir de l'ID
        $event = $repo->  findOneBy(['id'=>$id]);
        if (!$event){
            $this->addFlash('error',"Sorry! We can't find this event");
            return $this->redirectToRoute('event');
        }
        // Récupérer le nombre de billets disponibles
        $ticketsRemaining = $event->getNbplaces();

        return $this->render('description/show_event.html.twig', [
            'event' => $event,
            'tickets_remaining' => $ticketsRemaining
        ]);
    }
}

