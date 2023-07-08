<?php
namespace App\Controller;

use App\Entity\Client;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Event;
use App\Entity\Feedback;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session, EventRepository $eventRepository,ManagerRegistry $doctrine)
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
    //return $this->render('main/index.html.twig',['eventT' => $eventT,'eventW' => $eventW,'eventU' => $eventU,'tab'=>$tab,'events'=>$dataevent]);


        $cart = $session->get('cart', []);
        $cartWithData = [];
        $total = 0;
        foreach ($cart as $id => $quantity) {
            $event = $eventRepository->find($id);
            if (!$event) {
                continue;
            }
            $subtotal = $event->getPrice() * $quantity;
            $total += $subtotal;
            array_push($cartWithData, ['event' => $event, 'quantity' => $quantity]);
        }
    //    dd($total);
    //    dd($cartWithData);

        return $this->render('main/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total,'eventT' => $eventT,'eventW' => $eventW,'eventU' => $eventU,'tab'=>$tab,'events'=>$dataevent
        ]);
    }



    /**
* @Route("/cart/add/{id}", name="cart_add")
*/
    public function add($id, SessionInterface $session)
    {
//        dd($id);
        $cart = $session->get('cart', []);
        if (!isset($cart[$id])) {
            $cart[$id] = 1;
        }
        else {
            $cart[$id]++;
        }
        $session->set('cart', $cart);
//        dd($cart);
        return $this->redirectToRoute('cart_index');
    }



/**
* @Route("/cart/remove/{id}", name="cart_remove")
*/
public function remove($id, SessionInterface $session)
{
 $cart = $session->get('cart', []);
 if (!empty($cart[$id])) {
 unset($cart[$id]);
}
 $session->set('cart', $cart);
 return $this->redirectToRoute("cart_index");
}


    /**
     * @Route("/cart/checkout", name="cart_payment")
     */
    public function payment(Request $request, SessionInterface $session, EventRepository $eventRepository)
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];
        $total = 0;
        foreach ($cart as $id => $quantity) {
            $event = $eventRepository->find($id);
            if (!$event) {
                continue;
            }
            $quantityFromForm = $request->request->get('quantity_'.$id); // Get quantity of tickets from the form
            $subtotal = $event->getPrice() * $quantityFromForm; // Calculate subtotal based on quantity from the form
            $total += $subtotal;
            array_push($cartWithData, ['event' => $event->getId(), 'quantity' => $quantityFromForm]); // Add event and quantity to cartWithData
        }

        $session->set('items',json_encode($cartWithData));

// Debug output
//        dd($total);
//dd($cartWithData);

        return $this->redirectToRoute('paymentEvent', [
            'items' => json_encode($cartWithData),
            'total' => $total,
        ]);
    }

}