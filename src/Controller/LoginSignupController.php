<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\AssignOp\Mod;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class LoginSignupController extends AbstractController
{

    #[Route('/loginsignup', name: 'login_signup')]
    public function index(ManagerRegistry $doctrine,Request $request,Session $session): Response
    {

        $check =$request->request->all();
        if (!$check){
            return $this->render('login_signup/index.html.twig',[
                'emailnon'=>'',
                'password'=>''
            ]);
        }
        $data = $request->request;
        $repo = $doctrine->getRepository(Client::class);
        $user = $repo->findOneBy(['username'=>$data->get('username')]);
        if ($user){
            dd("this exist");
        }
        else{
            $user = new Client();
            $user->setUsername($data->get('username'));
            //$user->setPassword($data->get('password'));

            
            //hash the password
            $hashedPassword = password_hash($data->get('password'),PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
            

            $user->setEmail($data->get('email'));

            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();

        }
        $session->set('username',$user->getUsername());
        return $this->redirect('main');
    }

    #[Route('/loginsigin', name: 'login_signin')]
    public function signin(ManagerRegistry $doctrine,Request $request,Session $session): Response
    {
        $check =$request->request->all();
        if (!$check){
            return $this->render('login_signup/index.html.twig',
            [
                'emailnon'=>'',
                'passwordnon'=>''
            ]
        );
        }
        $data = $request->request;
        $repo = $doctrine->getRepository(Client::class);
        $user = $repo->findOneBy(['email'=>$data->get('email')]);
        if ($user){
            //hash the password
            $passwordMatches = password_verify($data->get('password'),$user->getPassword());
            if ($passwordMatches){
                $session->set('username',$user->getUsername());
            }
            else {
                $passwordnon = 'non';
                return $this->render("login_signup/index.html.twig",[
                    'emailnon'=>'',
                    'passwordnon'=>$passwordnon
                ]);
            }
        }
        else {
            $emailnon = 'non';
            return $this->render("login_signup/index.html.twig",[
                'emailnon'=>$emailnon,
                'passwordnon'=>''
            ]);
        }
        return $this->redirect('main');
    }

    #[Route('/delete',name:'delete_session')]
    public function delete_session(Session $session):Response
    {
        $session->clear();
        return $this->render('main/index.html.twig');
    }
}
