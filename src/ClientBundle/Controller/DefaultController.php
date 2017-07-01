<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if($this->getUser() == null){
            $user = null;
            return $this->redirect('login');
        } else {
            $user = $this->getUser()->getId();

            $newsletters = $em->createQuery('
                SELECT n
                FROM ClientBundle:Newsletter n, ClientBundle:Concerned c, UserBundle:User u, ClientBundle:Behove b, ClientBundle:MailingGroup mg
                WHERE u.id = b.users
                AND b.adminGroups = mg.id
                AND mg.id = c.mailingGroups
                AND c.newsletters = n.id
                AND u.id = :id
            ')->setParameter('id', $this->getUser()->getId());

            return $this->render('ClientBundle:Default:default.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
                'id_user' => $user,
                'newsletters' => $newsletters->getResult()
            ]);
        }
    }
}
