<?php
namespace ClientBundle\Controller;

use ClientBundle\Entity\MailingGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\Entity\Newsletter;
use ClientBundle\Form\NewsletterType;
use ClientBundle\Entity\Concerned;

/**
 * Created by PhpStorm.
 * User: matth
 * Date: 12/06/2017
 * Time: 09:16
 */

class NewsletterController extends Controller
{
    public function newsletterFormAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $newsletter = new Newsletter();

        $repositoryMailingGroups = $em->getRepository('ClientBundle:MailingGroup');

        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $idMailingGroup = $_POST['mailingGroup'];

            $newsletter->setFavorite(false);

            $em->persist($newsletter);
            $em->flush();

            $group = $repositoryMailingGroups->findOneById($idMailingGroup);
            $concerned = new Concerned();
            $concerned->setNewsletters($newsletter);
            $concerned->setMailingGroups($group);

            $em->persist($concerned);
            $em->flush();

            $this->addFlash('success', 'Création de la newsletter réussie');

            return $this->redirectToRoute('client_homepage');
        }

        $mailingGroups = $em->createQuery('
            SELECT mg
            FROM UserBundle:User u, ClientBundle:Behove b, ClientBundle:MailingGroup mg
            WHERE u.id = b.users
            AND b.adminGroups = mg.id
            AND u.id = :id
        ')->setParameter('id', $this->getUser()->getId());;

        return $this->render('ClientBundle:newsletterForm:newsletter.html.twig', array(
            'form' => $form->createView(),
            'mailingGroups' => $mailingGroups->getResult(),
            'id_user' => $this->getUser()->getId()
        ));
    }

    public function chooseForNewsletterAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $mailingGroups = $em->createQuery('
            SELECT mg
            FROM ClientBundle:MailingGroup mg, ClientBundle:Behove b, UserBundle:User u
            WHERE u.id = b.users
            AND b.adminGroups = mg.id
            AND u.id = :id
        ')->setParameter('id', $this->getUser()->getId());

        return $this->render('ClientBundle:newsletterForm:selectGroup.html.twig', array(
            'mailingGroups' => $mailingGroups->getResult(),
            'id_user' => $this->getUser()->getId()
        ));
    }

    public function sendNewsletterAction(Request $request, $idMailingGroup = null, $idAction){
        $em = $this->getDoctrine()->getManager();
        $repositoryNewsletter = $em->getRepository('ClientBundle:Newsletter');
        $repositoryMailingGroup = $em->getRepository('ClientBundle:MailingGroup');

        if($request->getMethod() == "POST" && $idAction == 1) {

            $idNewsletter = $_POST['newsletter'];

            $newsletter = $repositoryNewsletter->findOneById($idNewsletter);
            $group = $repositoryMailingGroup->findOneById($idMailingGroup);
            $users = $group->getUsers();

            foreach ($users as $user) {
                $s = \Swift_Message::newInstance()
                    ->setSubject($newsletter->getTitle())
                    ->setFrom($this->getUser()->getEmail())
                    ->setTo($user->getUsers()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'Emails/newsletter.html.twig',
                            array(
                                'newsletter' => $newsletter,
                                'email' => $user->getUsers()->getEmail()
                            )
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($s);
            }

            $this->addFlash('success', 'Envoi des newsletters réalisé avec succès');

            return $this->redirectToRoute('client_homepage');
        } else {
            $idMailingGroup = $_POST['mailingGroup'];
        }

        $newsletters = $em->createQuery('
            SELECT n
            FROM ClientBundle:Newsletter n, ClientBundle:Concerned c, ClientBundle:MailingGroup mg
            WHERE mg.id = c.mailingGroups
            AND c.newsletters = n.id
            AND mg.id = :idGroup
        ')->setParameter('idGroup', $idMailingGroup);

        return $this->render('ClientBundle:newsletterForm:send.html.twig', array(
            'newsletters' => $newsletters->getResult(),
            'idMailingGroup' => $idMailingGroup,
            'id_user' => $this->getUser()->getId()
        ));

    }
}