<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Event;
use App\Entity\Ticket;
use App\Service\PdfService;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AddEventController extends AbstractController
{
    #[Route('/addEvent', name: 'app_event')]
    public function addEvent(ManagerRegistry $doctrine,Request $request,Session $session): Response
    {
        
        $repo = $doctrine->getRepository(Client::class);
        

        $client = $repo->findOneBy(['username'=>$session->get('username')]);
        $check =$request->request->all();
        if (!$check){
            return $this->render('addEvent/addevent.html.twig');
        }
        $event = new Event();
        $imageFile = $request->files->get('image');
        if($imageFile){
            $newfilename = uniqid().'.'.$imageFile->guessExtension();
            try{
                $imageFile->move(
                    $this->getParameter('kernel.project_dir').'/public/assets/images/uploads',
                    $newfilename
                );
                $event->setImage($newfilename);

            }catch(FileException $e){

            }
        }



        $data = $request->request;
        $event->setName($data->get('name'));
        $event->setEventType($data->get('type'));
        $date = DateTimeImmutable::createFromFormat('Y-m-d',$data->get('date'));
        $event->setDate($date);
        $event->setDescription($data->get('description'));
        $event->setLatitude($data->get('latitude'));
        $event->setLongitude(($data->get('longitude')));
        $event->setNbplaces($data->get('nbrplace'));
        $event->setPrice($data->get('price'));
        $event->setClientid($client);
        

        $manager = $doctrine->getManager();
        $manager->persist($event);
        $manager->flush();

    
        return $this->redirectToRoute('main');
    }


}
