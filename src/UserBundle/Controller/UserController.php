<?php
namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use ClientBundle\Entity\Csv;
use ClientBundle\Form\CsvType;
use ClientBundle\Entity\Belongs;
use ClientBundle\Entity\Behove;
use ClientBundle\Entity\MailingGroup;
use UserBundle\Form\UserModifyType;
use UserBundle\Form\UserType;

/**
 * Created by PhpStorm.
 * User: matth
 * Date: 28/03/2017
 * Time: 16:19
 */

class UserController extends Controller
{
    public function selectModeAction(Request $request){
        if($request->getMethod() == 'POST'){
            $mode = $_POST['selectMode'];
            if($mode == 0){
                return $this->redirectToRoute('user_form_csv');
            } else if($mode == 1){
                return $this->redirectToRoute('user_form_add');
            }
        }
        return $this->render('ClientBundle:addUser:selectMode.html.twig', array(
            'id_user' => $this->getUser()->getId()
        ));
    }

    public function addUserAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $repositoryGroup = $em->getRepository('ClientBundle:MailingGroup');

        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user->setEnabled(1);
            $user->setPassword($user->getNom().'.'.$user->getPrenom());
            $user->setRoles(array('ROLE_USERS'));

            $em->persist($user);
            $em->flush();

            $belongs = new Belongs();
            $belongs->setUsers($user);

            $behove = new Behove();
            $behove->setUsers($this->getUser());

            $method = $_POST['chooseMethod'];
            if($method == 0){
                $idMailingGroup = $_POST['selectGroup'];
                $mailingGroup = $repositoryGroup->findOneById($idMailingGroup);
                $belongs->setMailingGroups($mailingGroup);
            } else if($method == 1){
                $label = $_POST['labelGroup'];
                $mailingGroup = new MailingGroup();
                $mailingGroup->setLabel($label);
                $em->persist($mailingGroup);
                $em->flush();
                $belongs->setMailingGroups($mailingGroup);
                $behove->setAdminGroups($mailingGroup);
            }

            $em->persist($belongs);
            $em->flush();

            $em->persist($behove);
            $em->flush();

            $this->addFlash('success', 'Utilisateur ajouté');

            return $this->redirectToRoute('client_homepage');
        }

        $mailingGroups = $em->createQuery('
            SELECT mg
            FROM ClientBundle:MailingGroup mg, ClientBundle:Behove b, UserBundle:User u
            WHERE u.id = b.users
            AND b.adminGroups = mg.id
            AND u.id = :id
        ')->setParameter('id', $this->getUser()->getId());

        return $this->render('ClientBundle:addUser:add_one_user.html.twig', array(
            'form' => $form->createView(),
            'mailingGroups' => $mailingGroups->getResult(),
            'id_user' => $this->getUser()->getId()
        ));
    }

    public function addFormAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $csv = new Csv();

        $form = $this->createForm(CsvType::class, $csv);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            //__ Création du groupe

            $label = $_POST['userGroupName'];

            $mailingGroup = new MailingGroup();

            $mailingGroup->setLabel($label);

            $em->persist($mailingGroup);

            $em->flush();

            //__Admin du groupe

            $behove = new Behove();

            $behove->setUsers($this->getUser());

            $behove->setAdminGroups($mailingGroup);

            $em->persist($behove);

            $em->flush();

            //__ Récupération des nouveaux user

            $file = $csv->getCsv();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('csv_directory'),
                $fileName
            );

            $csv->setCsv($fileName);

            $handle = fopen($this->getParameter('csv_directory').'/'.$fileName, "r");

            if ($handle) {
                while (!feof($handle)) {
                    $currentLine = fgetcsv($handle);
                    if ($currentLine)
                        $data[] = $currentLine;
                }

                fclose($handle);
            }
            $i = 0;
            foreach($data as $line){
                for($j = $i; $j < count($data); $j++){
                    if($line[2] == $data[$j][2]){
                        unset($data[$j]);
                    }
                }
                $user = new User();
                $user->setUsername($line[0].'.'.$line[1]);
                $user->setEmail($line[2]);
                $user->setEnabled(1);
                $user->setNom($line[1]);
                $user->setPrenom($line[0]);
                $user->setPassword($line[0].'.'.$line[1]);
                $user->setRoles(array('ROLE_USERS'));

                $em->persist($user);
                $em->flush();

                //__ Liaison user et groupe
                $belongs = new Belongs();
                $belongs->setMailingGroups($mailingGroup);
                $belongs->setUsers($user);

                $em->persist($belongs);
                $em->flush();

                $i = $i + 1;
            }

            unlink($this->getParameter('csv_directory'.'/'.$fileName));

            $this->addFlash('success', 'Utilisateurs ajoutés');

            return $this->redirectToRoute('client_homepage');
        }

        return $this->render('ClientBundle:addUser:add_user.html.twig', array(
            'form' => $form->createView(),
            'id_user' => $this->getUser()->getId()
        ));
    }

    public function modifyFormAction(Request $request, $userId){
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('UserBundle:User');

        $user = $repository->findOneById($userId);

        $form = $this->createForm(UserModifyType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Modification de l\'utilisateur réussie');

            return $this->redirectToRoute('client_homepage');
        }

        return $this->render('ClientBundle:modifyUser:modify_user.html.twig', array(
            'form' => $form->createView(),
            'id_user' => $this->getUser()->getId()
        ));
    }

    public function unsubscribeAction(Request $request, $userMail){
        $em = $this->getDoctrine()->getManager();

        $repositoryUser = $em->getRepository('UserBundle:User');

        $user = $repositoryUser->findOneByEmail($userMail);

        $groups = $user->getMailingGroups();

        foreach($groups as $group){
            $em->remove($group);
            $em->flush();
        }

        return $this->render('ClientBundle:unsubscribe:end.html.twig');
    }
}