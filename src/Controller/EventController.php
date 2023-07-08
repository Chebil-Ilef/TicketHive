<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\EventRepository;
use App\Entity\Event;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Symfony\Component\Validator\Constraints\Regex;
use DateTime;

class EventController extends AbstractController
{
    #[Route('/event', name: 'event')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $reposity = $doctrine -> getRepository(Event::class);
        $event = $reposity -> findAll();
        return $this->render('event/index.html.twig',['events' => $event]);
    }
    #[Route('/event/{eventType}', name : 'event.filterType')]
    public function filterByType (ManagerRegistry $doctrine,$eventType): Response {
        $reposity = $doctrine -> getRepository(Event::class);
        $event = $reposity ->findBy(['event_type' => $eventType]);
        if (!$event) {
            $this->addFlash('error',"No such event with this type");
            return $this -> redirectToRoute('event');
        }
        return $this -> render ('event/index.html.twig',['events' => $event]);
    }
    #[Route('/event/filter/{type}',name : 'event.filter')]
    public function filterBy (ManagerRegistry $doctrine,$type) : Response {
        $reposity = $doctrine -> getRepository(Event::class);
        switch ($type){
            case 'PriceAsc' : 
                        $event = $reposity -> findBy([],['price' => 'ASC']);
                        break;
            case 'PriceDesc' :
                        $event = $reposity -> findBy([],['price' => 'DESC']);
                        break;
            case 'DateAsc' : 
                        $event = $reposity -> findBy([],['date' => 'ASC']);
                        break;
                    case 'DateDesc' :
                        $event = $reposity -> findBy([],['date' => 'DESC']);
                        break;
            case 'Runningout' :
                $event = $reposity -> findBy([],['nbplaces' => 'ASC']);
                break;
            default :
                $this->addFlash('error',"This filter is not available");
                return $this -> redirectToRoute('event');
        }
        return $this -> render ('event/index.html.twig',['events' => $event]);
    }
    #[Route('/main/Today',name : 'event.filter.today')]
    public function filterToday (ManagerRegistry $doctrine) : Response {
        $reposity = $doctrine -> getRepository(Event::class);
        $today = new DateTime();
        $eventT = $reposity -> findByDate ($today);
        return $this->render('main/index.html.twig', ['events' => $event]);
    }
    #[Route('/main/Weekend',name : 'event.filter.weekend')]
    public function filterWeekend (ManagerRegistry $doctrine) : Response {
        $reposity = $doctrine -> getRepository(Event::class);
        $threeDaysAhead = (new DateTime())->modify('+3 days');
        $today = new DateTime();
        $event = $reposity -> findByDateRange ($threeDaysAhead,$today);
        return $this->render('main/index.html.twig', ['events' => $event]);
    }
    #[Route('/main/Upcomings',name : 'event.filter.upcoming')]
    public function filterUpcoming (ManagerRegistry $doctrine) : Response {
        $reposity = $doctrine -> getRepository(Event::class);
        $date = (new DateTime())->modify('+2 weeks');
        $event = $reposity -> findByDateUpcoming ($date);
        return $this->render('main/index.html.twig', ['events' => $event]);
    }
    #[Route('/event/Search/Keywords/{keywords}', name : 'event.search')]
    public function search (ManagerRegistry $doctrine,$keywords = null) : Response {
        $reposity = $doctrine ->getRepository(Event::class);
        if (!$keywords) {
            return $this->redirectToRoute('event');}
        $event = $reposity -> findByKeywords ($keywords);
        if (!$event) {
            $this->addFlash('error',"Sorry!!,No such event fits your description");
            return $this -> redirectToRoute('event');
        }
        return $this -> render ('event/index.html.twig',['events' => $event]);
    }
}
