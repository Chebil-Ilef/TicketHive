<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/update', name: 'app_update')]
    public function index(ManagerRegistry $doctrine,Request $request,Session $session): Response
    {
        $check =$request->request->all();
        if (!$check){
            return $this->render('update/index.html.twig');
        }

        $repoClient = $doctrine->getRepository(Client::class);
        $Client = $repoClient->findOneBy(['username'=>$session->get('username')]);

        $data = $request->request;
        $email = $data->get('email');
        $username = $data->get('username');
        $oldpassword = $data->get('oldpassword');
        $newpassword = $data->get('newpassword');
        $passwordisvalid = $data->get('confirm');

        
        $user = $repoClient->findOneBy(['username'=>$username]);
        if($user){
            dd("this exist");
        }
        else {
            $Client->setEmail($email);
            $Client->setUsername($username);

            //$hashedPassword = password_hash($oldpassword,PASSWORD_DEFAULT);
            $passwordMatches = password_verify($oldpassword,$Client->getPassword());
            //dd($passwordMatches);

            if ($passwordMatches){
                //$hashedPasswordnew = password_hash($newpassword,PASSWORD_DEFAULT);
                //$hasedpasswordconfirm = password_hash($passwordisvalid,PASSWORD_DEFAULT);
                if ($passwordisvalid == $newpassword){
                    $hashedPasswordnew = password_hash($newpassword,PASSWORD_DEFAULT);
                    $Client->setPassword($hashedPasswordnew);
                }
                else {
                    dd("password new 8alet");
                }
                
            }
            else {
                dd('password old 8alet');
            }
        }

        $manager = $doctrine->getManager();
        $manager->flush();

        $session->clear();

        return $this->redirect('main');
    }
}
