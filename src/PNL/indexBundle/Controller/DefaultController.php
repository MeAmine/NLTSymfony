<?php

namespace PNL\indexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PNL\indexBundle\Entity\Client;
use PNL\indexBundle\Entity\Groupe;
use PNL\indexBundle\Entity\NewsLetter;
use PNL\indexBundle\Entity\Campagne;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('base.html.twig',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' ));
    }
    public function clientAction()
    {
    	$repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
    	$groupe = $repository->findAll();
    	$repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
    	$clients = $repositoryC->findAll();
      $repositoryCampagne = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
      $campagne = $repositoryCampagne->findAll();
        return $this->render('base.html.twig',array('page'=>'client','titre' =>'Projet NewsLetter','soustitre'=>'Édition des clients','clients'=>$clients, 'groupes' => $groupe,'campagnes'=>$campagne ));
    }
    public function campagneAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
        $campagne = $repository->findAll();
        return $this->render('base.html.twig',array('page'=>'campagne','titre' =>'Projet NewsLetter','soustitre'=>'Édition des clients','campagnes'=>$campagne));
    }
    public function clientDuGroupeAction($groupeId)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
        $groupe = $repository->find($groupeId);
        $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
        $clients = $repositoryC->findAll();
        $titre = "NewsLetter";
        $clientsList = array();
        foreach ($clients as $clt) {
            foreach ($clt->getGroupe() as $grp) {
                if($grp->getId() == $groupe->getId())
                {
                 array_push($clientsList, $clt); 
             }

         }
     }
     return $this->render('base.html.twig',array('page'=>'userbygroupe','titre' =>$groupe->getNom(),'soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda','clients'=>$clientsList ));
 }

 public function newsletterCampagneAction($campagneId)
 {
    $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
    $campagne = $repository->find($campagneId);
    $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:NewsLetter');
    $newsletters = $repositoryC->findAll();
    $titre = "NewsLetter";
    $newslettersList = array();
    foreach ($newsletters as $nl) {
        foreach ($nl->getCampagne() as $cmp) {
            if($cmp->getId() == $campagne->getId())
            {
             array_push($newslettersList, $nl); 
         }

     }
 }
 return $this->render('base.html.twig',array('page'=>'newslettersByCampagne','titre' =>$campagne->getNom(),'soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda','newsletter'=>$newslettersList ));
}
public function campagnemanagementAction()
{
    $request = Request::createFromGlobals();
    $camapgneList = $request->request->get('camapgneList');      
    $submitInfo = $request->request->get('_submit');
    $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
    $em = $this->getDoctrine()->getManager();
    
    $campagne = $repositoryC->findOneById($camapgneList);       
    
    $titre = "";
    if ($submitInfo == "Supprimer") {                   
        $em->remove($campagne);                           
        $em->flush();   
        $titre = "Campagne ". $campagne->getNom()." supprimé";

        return $this->render('base.html.twig',array('page'=>'index','titre' =>$titre,'soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' ));
    }
    elseif ($submitInfo == "Modifier") {
        $i = 0;
        foreach ($campagne as $campagneDelete) {                
            $i ++;
        }
        if($i>2)
        {
            
        }
        else
        {
            return $this->redirectToRoute('pnl_index_updateCampagne',array('campagneId' => $campagne->getId() ));
            
            
        }           
    }
    elseif ($submitInfo == "Ajouter une campagne") {
        
        return $this->redirectToRoute('pnl_index_ajoutCampagne');
        
        
    }
    elseif ($submitInfo == "Voir les newsletters de la campagne") {
     
        return $this->redirectToRoute('pnl_index_NewsletterCampagne',array('campagneId' =>$campagne->getId() ));
    }
    elseif ($submitInfo == "Envoyer") {
     
        return $this->redirectToRoute('pnl_index_NewsletterCampagneSend',array('campagneId' =>$campagne->getId() ));
    }
    else
    {
       return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
   }
}
public function CampagneSendAction($campagneId)
{
    $repositoryCampagne = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
    $campagne = $repositoryCampagne->findOneById($campagneId);
    $repositoryN = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:NewsLetter');
    $newsletters = $repositoryN->findAll();
    

    $newslettersList = array();
    foreach ($newsletters as $nl) {
        foreach ($nl->getCampagne() as $cmp) {
            if($cmp->getId() == $campagne->getId())
            {
             array_push($newslettersList, $nl); 
           }
         }
     }
    $repositoryClient = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
    $clients = $repositoryClient->findAll();

    $clientsList = array();

        foreach ($campagne->getClient() as $cmp) {
             array_push($clientsList, $cmp); 
         }

    
    foreach ($clientsList as $clt) {
      foreach ($newslettersList as $nll) {
        $cryptedClient = $clt->getId();
        $LinkDesactivateClient = "<a href=\"192.168.10.10/app_dev.php/DesactiveClient/".$cryptedClient."\">CLIQUEZ ICI</a>";
        $DesactivationMessage =" <br/><br/><br/> Vous pouvez désactiver les newsletters en cliquant sur le lien ci-dessous.<br/> ".$LinkDesactivateClient;
        $htmlPath = "http://192.168.10.10/".$nll->getHtmlPath();
        $mailContent = file_get_contents($htmlPath);
        $bodymail = $mailContent.$DesactivationMessage.$nll->getHtmlPath();
        $senderName = $nll->getSenderName();
        if(!filter_var($senderName, FILTER_VALIDATE_EMAIL))
            $senderName = "cochie@cochise.fr";
        var_dump($bodymail."    ".$nll->getSenderName());
        $message = \Swift_Message::newInstance()
        ->setSubject('NewsLetter Projet Arias Carré Bréda')
            ->setFrom($senderName) // notre mail
            ->setTo($clt->getEmail())
            ->setBody($bodymail)
            ->setContentType('text/html')
            ;
          $this->get('mailer')->send($message);
          $titre = " SEND";
      }
    }
    return $this->render('base.html.twig',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' ));
}


public function updateCampagneAction($campagneId,Request $request = NULL)
{
    $em = $this->getDoctrine()->getManager();
    $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
    
    $campagneToUpdate = $repositoryC->findOneById($campagneId);
    $form = $this->createFormBuilder($campagneToUpdate)
    ->add('nom',      TextType::class,array('data' => $campagneToUpdate->getNom() ))
    ->add('DateDebut',      DateType::class,array('data' => $campagneToUpdate->getDateDebut() ))
    ->add('DateFin',      DateType::class,array('data' => $campagneToUpdate->getDateFin() ))
    ->add('save',      SubmitType::class)
    ->getForm();
    if ($request->isMethod('POST')) {
                          // On fait le lien Requête <-> Formulaire
                          // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);

                          // On vérifie que les valeurs entrées sont correctes
                          // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
                            // On enregistre notre objet $advert dans la base de données, par exemple
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                            // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
    }
    return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
}

return $this->render('base.html.twig',array('page'=>'updateGroupe','titre' =>'campagneupdate','soustitre'=>'Modification de Groupe','form' => $form->createView()));
}     
public function ajoutCampagneAction(Request $request)
{
        // On crée un objet Advert
    $campagne = new Campagne();
    
    // J'ai raccourci cette partie, car c'est plus rapide à écrire !
    $form = $this->createFormBuilder($campagne)
    ->add('nom',      TextType::class) 
    ->add('DateDebut',      DateType::class)
    ->add('DateFin',      DateType::class)
    ->add('save',      SubmitType::class)     
    ->getForm()
    ;

    // Si la requête est en POST
    if ($request->isMethod('POST')) {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $advert dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();
        $em->persist($campagne);
        $em->flush();
        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
    }
}
return $this->render('base.html.twig',array('page'=>'ajoutCampagne','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda','form' => $form->createView()));
}

public function newsletterAction()
{
    $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
    $groupe = $repository->findAll();
    $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
    $campagne = $repositoryC->findAll();
    
    return $this->render('base.html.twig',array('page'=>'NewsLetter','titre' =>'Projet NewsLetter','soustitre'=>'Écriture de la newsletter','groupes'=>$groupe,'campagnes'=>$campagne));
}
public function addNLToCampagneAction()
{
    $request = Request::createFromGlobals();
    $campagneId = $request->request->get('campagne');
    $textarea = $request->request->get('textareaCampagne');
    $subject = $request->request->get('subjectCampagne');
    $sender = $request->request->get('senderNameCampagne');
    $newsletter = new NewsLetter();
    $newsletter->setSenderName($sender);
    $newsletter->setSubject($subject);
    $newsletter->setDateCreation(new \DateTime('now'));
    $filename = sprintf('uploads/NewsletterHTML/NewLetters-%s-%s.html', date('d-m-Y-H-i-s'),$campagneId);
    $fh = fopen($filename, 'w') or die("can't open file");
    fwrite($fh, $textarea);        
    fclose($fh);
    $newsletter->setHtmlPath($filename);
    $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
    $campagne = $repository->findOneById($campagneId);
    $newsletter->addCampagne($campagne);
    $em = $this->getDoctrine()->getManager();        
    $em->persist($newsletter);
    $em->flush();
    $repositoryCampagne = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
    $campagne = $repositoryCampagne->findOneById($campagneId);
   
    $campagneBack = $repositoryCampagne->findAll();
    return $this->render('base.html.twig',array('page'=>'campagne','titre' =>'NewsLetter ajouté à la campagne '.$campagne->getNom(),'soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda','campagnes'=>$campagneBack ));
}
public function envoiAction()
{
    $CryptageKey = "GaelAlexandreTom";
    $salt = '$6$rounds=5000$'.$CryptageKey;
    $request = Request::createFromGlobals();
    $textarea = $request->request->get('textarea');
    $groupiie = $request->request->get('groupe');
    $senderName = $request->request->get('senderName');
    if(!filter_var($senderName, FILTER_VALIDATE_EMAIL))
        $senderName = "cochie@cochise.fr";

    $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
    $repositoryClient = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
    $groupe = $repository->findOneById($groupiie);
    $clients = $repositoryClient->findAll(); 

    $titre = "titres";
    foreach ($clients as $clt) {			
        if($clt->getGroupe()[0] != null && $groupe != null)
        {
            $titre = $titre.$clt->getGroupe()[0]->getId();
            if($clt->getGroupe()[0]->getId() == $groupiie && $clt->getIsClient() == 1)
            {
		            $cryptedClient = $clt->getId();//crypt($clt->getId(),$salt);
                $LinkDesactivateClient = "<a href=\"172.20.40.3:8080/app_dev.php/DesactiveClient/".$cryptedClient."\">CLIQUEZ ICI</a>";
                $DesactivationMessage =" <br/><br/><br/> Vous pouvez désactiver les newsletters en cliquant sur le lien ci-dessous.<br/> ".$LinkDesactivateClient;
                $bodymail = $textarea. $DesactivationMessage;
				//$titre = $bodymail;
                $message = \Swift_Message::newInstance()
                ->setSubject('NewsLetter Projet Arias Carré Bréda')
                    ->setFrom($senderName) // notre mail
                    ->setTo($clt->getEmail())
                    ->setBody($bodymail)
                    ->setContentType('text/html')
                    ;
                    $this->get('mailer')->send($message);
                    $titre = " SEND";
                    
                }
            }
        }
        
        $groupeName = $repository->findOneById($groupiie)->getNom();
//    	 $snappy = $this->get('knp_snappy.pdf');
        $html = $textarea;
//        $filename = sprintf('NewLetters-%s-%s.pdf', date('d-m-Y-H-i-s'),$groupeName);
//        $snappy->generateFromHtml($html,$filename);
        
        return $this->render('base.html.twig',array('page'=>'send','titre' =>$titre,'soustitre'=>'NewsLetter envoyée','groupe' => $groupeName ));
    }
    public function DesactiveClientAction($cryptClient)
    {
        $CryptageKey = "GaelAlexandreTom";       
        $em = $this->getDoctrine()->getManager();
        $repositoryClient = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
        $clients = $repositoryClient->findOneById($cryptClient); 
        if($clients->getIsClient() == 1)
        {                        
         $clients->setIsClient(0);
         $em->flush();
         
     }
     try {
        foreach ($clients as $clts) {
            {
                if($clts->getIsClient() == 1)
                {
                    if ($cryptClient == $clts->getId()) {
                     $clts->setIsClient(0);
                     $em->flush();
                 }
             }
         }
     }            
 } catch (Exception $e) {
    throw $this->createAccessDeniedException('You cannot access this page!');
}
return $this->render('base.html.twig',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' ));
}
public function clientgroupeAction()
{
   $request = Request::createFromGlobals();
   $clientList = $request->request->get('clientList');
   $groupiie = $request->request->get('groupe');
   $campagneId = $request->request->get('campagne');
   $submitInfo = $request->request->get('_submit');
   $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
   $em = $this->getDoctrine()->getManager();
   $clients = $repositoryC->findById($clientList);
   $titre = "";
   if($submitInfo == "Ajouter au groupe")
   {
      $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
      $groupe = $repository->find($groupiie);
      

      foreach($clients as $clt)    	
      {    		
         $clt->addGroupe($groupe);
         
			  //$em->persist($repositoryC);
         $em->flush();
     }


     return $this->render('base.html.twig',array('page'=>'management','titre' =>'NewsLetter','soustitre'=>'NewsLetter envoyée','groupe'=>$groupe ));
 }
 elseif($submitInfo == "Ajouter à la campagne")
   {
      $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Campagne');
      $campagne = $repository->find($campagneId);
     

      foreach($clients as $clt)     
      {       
         $campagne->addClient($clt);
         
        //$em->persist($repositoryC);
         $em->flush();
     }


     return $this->render('base.html.twig',array('page'=>'campagne','titre' =>'NewsLetter','soustitre'=>'NewsLetter envoyée' ));
 }
 elseif ($submitInfo == "Supprimer") {
  foreach ($clients as $clientDelete) {    			
     $em->remove($clientDelete);
 }
 $em->flush();	
 return $this->render('base.html.twig',array('page'=>'index','titre' =>'Clients supprimés','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' ));
}
elseif ($submitInfo == "Modifier") {
  $i = 0;
  foreach ($clients as $clientDelete) {    			
     $i ++;
 }
 if($i>2)
 {
    
 }
 else
 {
     return $this->redirectToRoute('pnl_index_updateClient',array('clientsId' => $clients[0]->getId(), ));
     
     
 }  
}
elseif ($submitInfo == "Ajouter un client") 
{
   return $this->redirectToRoute('pnl_index_ajoutClient'); 			 
}  		


return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
}

public function ajoutClientAction(Request $request)
{
    	// On crée un objet Advert
    $client = new Client();
    
    // J'ai raccourci cette partie, car c'est plus rapide à écrire !
    $form = $this->createFormBuilder($client)
    ->add('nom',      TextType::class)
    ->add('prenom',     TextType::class)
    ->add('email',   TextType::class)
    ->add('entreprise',    TextType::class,array('required' => false))
    ->add('date_naissance', DateType::class, array('required' => false))
    ->add('civilite', ChoiceType::class,array('choices' => array('Mr' =>'Mr' ,'Mme'=>'Mme' )) )
    ->add('ville',   TextType::class)
    ->add('pays',   EntityType::class,array('class' => 'PNLindexBundle:Pays','choice_label'=>'countryName'))
    ->add('save',      SubmitType::class)
    ->getForm()
    ;

    // Si la requête est en POST
    if ($request->isMethod('POST')) {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $advert dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();
        $client->setIsClient(1);
        $em->persist($client);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
    }
}
return $this->render('base.html.twig',array('page'=>'ajoutClient','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda','form' => $form->createView()));
}

public function updateClientAction($clientsId,Request $request = NULL) 
{
 $em = $this->getDoctrine()->getManager();
 $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
 
 $clienToUpdate = $repositoryC->findOneById($clientsId);
    			// J'ai raccourci cette partie, car c'est plus rapide à écrire !
 $form = $this->createFormBuilder($clienToUpdate)
 ->add('nom',      TextType::class,array('data' => $clienToUpdate->getNom() ))
 ->add('prenom',     TextType::class,array('data' => $clienToUpdate->getPrenom() ))
 ->add('email',   TextType::class,array('data' => $clienToUpdate->getEmail() ))
 ->add('entreprise',    TextType::class,array('required' => false,'data'=>$clienToUpdate->getEntreprise()))
 ->add('date_naissance', DateType::class, array('required' => false,'data'=>$clienToUpdate->getDatenaissance()))			      
 ->add('ville',   TextType::class,array('data' => $clienToUpdate->getVille() ))
 ->add('pays',   EntityType::class,array('class' => 'PNLindexBundle:Pays','choice_label'=>'countryName','data'=>$clienToUpdate->Pays()))
 ->add('save',      SubmitType::class)
 ->getForm();
 if ($request->isMethod('POST')) {
					      // On fait le lien Requête <-> Formulaire
					      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

					      // On vérifie que les valeurs entrées sont correctes
					      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
					        // On enregistre notre objet $advert dans la base de données, par exemple
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

					        // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
   }
   return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
}

return $this->render('base.html.twig',array('page'=>'updateClient','titre' =>'Client','soustitre'=>'Modification de client','form' => $form->createView()));
}			  

public function groupeAction()
{
   $repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
   $groupe = $repository->findAll();
   $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Client');
   $clients = $repositoryC->findAll();
   return $this->render('base.html.twig',array('page'=>'groupe','titre' =>'Projet NewsLetter','soustitre'=>'Édition des groupes','clients'=>$clients, 'groupes' => $groupe ,'i'=>0));
}
public function updateGroupeAction($groupeId,Request $request = NULL)
{
 $em = $this->getDoctrine()->getManager();
 $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
 
 $groupeToUpdate = $repositoryC->findOneById($groupeId);
    			// J'ai raccourci cette partie, car c'est plus rapide à écrire !
 $form = $this->createFormBuilder($groupeToUpdate)
 ->add('nom',      TextType::class,array('data' => $groupeToUpdate->getNom() ))
 ->add('save',      SubmitType::class)
 ->getForm();
 if ($request->isMethod('POST')) {
					      // On fait le lien Requête <-> Formulaire
					      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

					      // On vérifie que les valeurs entrées sont correctes
					      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
					        // On enregistre notre objet $advert dans la base de données, par exemple
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

					        // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
   }
   return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
}

return $this->render('base.html.twig',array('page'=>'updateGroupe','titre' =>'Groupe','soustitre'=>'Modification de Groupe','form' => $form->createView()));
}		


public function groupeManagementAction()
{
   $request = Request::createFromGlobals();
   $groupeList = $request->request->get('groupList');    	
   $submitInfo = $request->request->get('_submit');
   $repositoryC = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Groupe');
   $em = $this->getDoctrine()->getManager();
   
   $groupe = $repositoryC->findOneById($groupeList);

    	//die(var_dump($groupe)."  ".$groupe."  ".$groupeList."     " .$submitInfo);
   
   $titre = "";
   if ($submitInfo == "Supprimer") {    		   		
      $em->remove($groupe);    			    		
      $em->flush();	
      $titre = "Groupe ". $groupe->getNom()." supprimé";

      return $this->render('base.html.twig',array('page'=>'index','titre' =>$titre,'soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' ));
  }
  elseif ($submitInfo == "Modifier") {
      $i = 0;
      foreach ($groupe as $groupeDelete) {    			
         $i ++;
     }
     if($i>2)
     {
        
     }
     else
     {
         return $this->redirectToRoute('pnl_index_updateGroupe',array('groupeId' => $groupe->getId() ));
         
         
     }    		
 }
 elseif ($submitInfo == "Ajouter un groupe") {
  
     return $this->redirectToRoute('pnl_index_ajoutGroupe');
     
     
 }
 elseif ($submitInfo == "Voir les utilisateurs du groupe") {
     
    return $this->redirectToRoute('pnl_index_clientDuGroupe',array('groupeId' =>$groupe->getId() ));
}
else
{
 return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
}
}  
public function ajoutGroupeAction(Request $request)
{
    	// On crée un objet Advert
    $groupe = new Groupe();
    
    // J'ai raccourci cette partie, car c'est plus rapide à écrire !
    $form = $this->createFormBuilder($groupe)
    ->add('nom',      TextType::class) 
    ->add('save',      SubmitType::class)     
    ->getForm()
    ;

    // Si la requête est en POST
    if ($request->isMethod('POST')) {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $advert dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();
        $em->persist($groupe);
        $em->flush();
        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirect($this->generateUrl('pnl_index_homepage',array('page'=>'index','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda' )));
    }
}
return $this->render('base.html.twig',array('page'=>'ajoutGroupe','titre' =>'Projet NewsLetter','soustitre'=>'Gaël Arias, Alexandre Carré, Tom Bréda','form' => $form->createView()));
}































}
