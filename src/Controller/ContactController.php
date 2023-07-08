<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{

    #[Route('/contact',name:'contact')]
    public function sendEmail(Request $request): Response
    {
        // $name = $request->request->get('name');
        // $email = $request->request->get('email');
        // $message = $request->request->get('message');

        // $mail = new PHPMailer(true);     // Paramètre true active les exceptions
        
        // try {
        //     // Paramètres du serveur SMTP
        //     $mail->SMTPDebug = 0;       // Désactiver le débogage SMTP
        //     $mail->isSMTP();            // Utiliser le transport SMTP
        //     $mail->Host = 'smtp.example.com';  // Le nom de votre serveur SMTP
        //     $mail->SMTPAuth = true;     // Activer l'authentification SMTP
        //     $mail->Username = 'user@example.com'; // Votre nom d'utilisateur SMTP
        //     $mail->Password = 'password'; // Votre mot de passe SMTP
        //     $mail->SMTPSecure = 'tls';  // Le protocole SMTP sécurisé à utiliser (tls ou ssl)
        //     $mail->Port = 587;          // Le port SMTP à utiliser

        //     // Destinataire et expéditeur
        //     $mail->setFrom('user@example.com', 'My Name');
        //     $mail->addAddress($email, $name); // Destinataire
        //     $mail->addReplyTo('user@example.com', 'My Name'); // Adresse de réponse

        //     // Contenu du message
        //     $mail->isHTML(true);       // Paramètre true pour envoyer un e-mail HTML
        //     $mail->Subject = 'Message from Contact Form'; // Sujet du message
        //     $mail->Body = $message;    // Corps du message HTML

        //     $mail->send();
        //     $this->addFlash('success', 'Votre message a été envoyé avec succès on reviendra vers vous dans le plus proche des délais.');
        // } catch (Exception $e) {
        //     $this->addFlash('error', 'Une erreur s\'est produite lors de l\'envoi de votre message.');
        // }
        //return $this->redirectToRoute('contact');
        return $this->render('contact/index.html.twig');
    }
}

