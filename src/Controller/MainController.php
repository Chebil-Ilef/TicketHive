<?php

namespace App\Controller;

use App\Entity\Client;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;
use App\Repository\EventRepository;
use App\Entity\Event;
use App\Entity\Feedback;
use DateTimeImmutable;

class MainController extends AbstractController
{
    #[Route('/main', name: 'main')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $repo = $doctrine->getRepository(Feedback::class);
        $repoClient = $doctrine->getRepository(Client::class);
        $feedbacks = $repo->findAll();
        $tab = [];
        foreach ($feedbacks as $key => $value) {
            // dump($value);
            // $client = $repoClient->find($value->getClientid());
            // dump($client);
            $username = $repoClient->findOneBy(['id'=>$value->getClientid()]);
            $tab[$username->getUsername()] = $value->getTextContent();
        }

        $repoevent = $doctrine->getRepository(Event::class);
        $dataevent = $repoevent->findAll();
        //dd($dataevent);
        
        // return $this->render('main/index.html.twig',[
        //     'tab'=>$tab,
        //     'events'=>$dataevent
        // ]);
        $reposity = $doctrine -> getRepository(Event::class);
        $today = new DateTime();
        $eventT = $reposity -> findByDate ($today);
        $threeDaysAhead = (new DateTime())->modify('+3 days');
        $eventW = $reposity -> findByDateRange ($threeDaysAhead,$today);
        $date = (new DateTime())->modify('+2 weeks');
        $eventU = $reposity -> findByDateUpcoming ($date);
    return $this->render('main/index.html.twig',['eventT' => $eventT,'eventW' => $eventW,'eventU' => $eventU,'tab'=>$tab,'events'=>$dataevent]);
    }

    #[Route('/main/createevent', name: 'main.create_event')]
    public function createEventPage(): Response
    {
        return $this->render('main/create.html.twig');
    }



}
