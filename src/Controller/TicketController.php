<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Ticket;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'ticket')]
    
    public function index(ManagerRegistry $doctrine,Request $request,Session $session): Response
    {
        $repo = $doctrine->getRepository(Client::class);
        $client = $repo->findOneBy(['username'=>$session->get('username')]);

        // dd($session->get('items')) ; 
        $event =  json_decode($session->get('items')) ; 
        // dd($event[0]->eve
        $entityManager = $doctrine->getManager();
        $repo = $entityManager->getRepository(Event::class);
        $result = $repo->findOneBy(['id'=>$event[0]->event]);
        $result->setNbplaces($result->getNbplaces()-1);

        $repoTicket = $doctrine->getRepository(Ticket::class);
        $ticket = new Ticket();

        $ticket->setEventid($result);
        $ticket->setClientid($client);


        $manager = $doctrine->getManager();
        $manager->persist($ticket);
        $manager->flush();


        $session->set('cart',[]);
        return $this->render('ticket/index.html.twig', [
            'event'=> $result
        ]);
    }
}