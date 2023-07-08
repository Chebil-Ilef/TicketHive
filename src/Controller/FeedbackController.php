<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Feedback;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    #[Route('/feedback', name: 'feedback')]
    public function index(ManagerRegistry $doctrine,Request $request,Session $session): Response
    {
        $repo = $doctrine->getRepository(Feedback::class);
        $data = $request->request;

        $repoClient = $doctrine->getRepository(Client::class);
        $client = $repoClient->findOneBy(['username'=>$session->get('username')]);

        $feedback = new Feedback();
        $feedback->setClientid($client);
        $feedback->setTextContent($data->get('feedback'));

        $manager = $doctrine->getManager();
        $manager->persist($feedback);
        $manager->flush();


        return $this->redirect('main');
    }
}
