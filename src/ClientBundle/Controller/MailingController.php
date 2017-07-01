<?php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailingController extends Controller
{
    public function indexAction(){
        return $this->render('ClientBundle:mailing:sendMail.html.twig');
    }

    public function sendAction(Request $request){

        if($request->getMethod() == 'POST'){
            $mail = $_POST['mail'];
            $subject = $_POST['subject'];
            $content = $_POST['content'];

            $s = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('matthieu.jonquet@gmail.com')
                ->setTo($mail)
                ->setBody(
                    $this->renderView(
                        'Emails/testMail.html.twig',
                        array('content' => $content)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($s);

            $request->getSession()->getFlashBag()->add('success', 'Mail envoyé');

        } else {
            $request->getSession()->getFlashBag()->add('error', 'Mail pas envoyé');
        }
        return $this->render('ClientBundle:Default:default.html.twig', array(
            "id_user" => $this->getUser()->getId()
        ));
    }
}