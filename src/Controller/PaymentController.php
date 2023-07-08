<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{   
    #[Route('/payment', name: 'paymentEvent')]

    public function checkout(Request $request): Response
    {
        $session = $request->getSession();
        // Récupérer les items et le total depuis payment function in CartController
        $total = $request->query->get('total');
        $items = json_decode($request->query->get('items'), true);
        //dd($items);

        return $this->render('payment/index.html.twig', [
            'total' => $total,
            'items' => $items
        ]);
    }

}
