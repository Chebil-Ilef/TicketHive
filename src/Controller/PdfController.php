<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }


    #[Route('/generated/{id}',name:'generated_pdf')]
    public function generatePdf(ManagerRegistry $doctrine,$id)
    {
        $repo = $doctrine->getRepository(Event::class);
        $event = $repo->findOneBy(['id'=>$id]);
        $html = $this->renderView('pdf/index.html.twig', [
            'event' => $event,
        ]);

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(20, 20, 20);
        $pdf->AddPage();
        $pdf->writeHTML($html);

        $pdf->Output('filename.pdf', 'D');

    }
}
