<?php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\Entity\MailingGroup;
use ClientBundle\Entity\Belongs;
use ClientBundle\Entity\Concerned;

/**
 * Created by PhpStorm.
 * User: matth
 * Date: 29/05/2017
 * Time: 11:48
 */

class MailingGroupController extends Controller
{
    public function groupFormAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        if($request->getMethod() == 'POST') {
            $id = $_POST['groupSelect'];

            return $this->redirectToRoute('mailing_group_form_management', array(
                'groupId' => $id
            ));

        } else {
            $mailingGroup = $em->createQuery('
                SELECT mg
                FROM UserBundle:User u, ClientBundle:Behove b, ClientBundle:MailingGroup mg
                WHERE u.id = b.users
                AND b.adminGroups = mg.id
                AND u.id = :id
            ')->setParameter('id', $this->getUser()->getId());
        }

        return $this->render('ClientBundle:groupManagement:chooseGroup.html.twig', array(
            'MailingGroup' => $mailingGroup->getResult(),
            'id_user' => $this->getUser()->getId()
        ));
    }

    public function groupManagementAction(Request $request, $groupId){
        $em = $this->getDoctrine()->getManager();
        $repositoryUser = $em->getRepository('UserBundle:User');
        $repositoryGroup = $em->getRepository('ClientBundle:MailingGroup');
        $repositoryNewsletter = $em->getRepository('ClientBundle:Newsletter');

        if($request->getMethod() == 'POST'){
            $method = $_POST['method'];

            if(isset($_POST['users'])) {
                $users = $_POST['users'];
            } else {
                $users = null;
            }

            $group = $_POST['mailingGroup'];

            if(isset($_POST['newsletters'])) {
                $newsletters = $_POST['newsletters'];
            } else {
                $newsletters = null;
            }

            if($method == '0'){
                if(!is_null($users)) {
                    foreach ($users as $u) {
                        $user = $repositoryUser->findOneById($u);
                        $mailingGroup = $repositoryGroup->findOneById($group);
                        $belongs = new Belongs();
                        $belongs->setUsers($user);
                        $belongs->setMailingGroups($mailingGroup);
                        $em->persist($belongs);
                        $em->flush();
                    }
                }
                if(!is_null($newsletters)) {
                    foreach ($newsletters as $n) {
                        $newsletter = $repositoryNewsletter->findOneById($n);
                        $mailingGroup = $repositoryGroup->findOneById($group);
                        $concerned = new Concerned();
                        $concerned->setNewsletters($newsletter);
                        $concerned->setMailingGroups($mailingGroup);
                        $em->persist($concerned);
                        $em->flush();
                    }
                }
            }

            $this->addFlash('success', 'Modification du groupe réussie');

            return $this->redirectToRoute('client_homepage');
        }

        $userss = $em->createQuery('
            SELECT u
            FROM UserBundle:User u, ClientBundle:Belongs b, ClientBundle:MailingGroup mg
            WHERE u.id = b.users
            AND b.mailingGroups = mg.id
            AND mg.id = :id
        ')->setParameter('id', $groupId);

        $newsleterss = $em->createQuery('
            SELECT n
            FROM ClientBundle:Newsletter n, ClientBundle:Concerned c, ClientBundle:MailingGroup mg
            WHERE n.id = c.newsletters
            AND c.mailingGroups = mg.id
            AND mg.id = :id
        ')->setParameter('id', $groupId);

        $mailingGroups = $em->createQuery('
            SELECT mg
            FROM UserBundle:User u, ClientBundle:Behove b, ClientBundle:MailingGroup mg
            WHERE u.id = b.users
            AND b.adminGroups = mg.id
            AND u.id = :id
        ')->setParameter('id', $this->getUser()->getId());

        return $this->render('ClientBundle:groupManagement:groupManagement.html.twig', array(
            'users' => $userss->getResult(),
            'mailingGroups' => $mailingGroups->getResult(),
            'newsletters' => $newsleterss->getResult(),
            'groupId' => $groupId,
            'id_user' => $this->getUser()->getId()
        ));

    }
}