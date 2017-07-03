<?php

namespace PNL\ExcelToBDDBundle\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PNL\indexBundle\Entity\Client;
use PNL\ExcelToBDDBundle\Entity\Excel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilder;
use PNL\ExcelToBDDBundle\Form\ExcelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DefaultController extends Controller
{
    public function processAction($path)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repositoryPath = $this->getDoctrine()->getManager()->getRepository('PNLExcelToBDDBundle:Excel');    
    	$excelInfo = $repositoryPath->findOneById($path);

    	$pathExcel = $excelInfo->getFile();	
    	$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($pathExcel);
    	$numCols = $phpExcelObject->getActiveSheet()->getHighestColumn();
    	$numRows = $phpExcelObject->getActiveSheet()->getHighestRow();
    	$dataToRetrun = array();    	
    	$repository = $this->getDoctrine()->getManager()->getRepository('PNLindexBundle:Pays');    	
		for ($row =2; $row <= $numRows; $row++) {
			$client = new Client();
			for ($column = 'A'; $column != $numCols; $column++) 
			{				   
				switch ($column) {
					case 'A':
						$cell = $phpExcelObject->getActiveSheet()->getCell($column.$row)->getValue();
						var_dump($cell);
						$client->setNom($cell);
						break;
					case 'B':
						$cell = $phpExcelObject->getActiveSheet()->getCell($column.$row)->getValue();
						$client->setPrenom($cell);
						break;
					case 'C':
						$cell = $phpExcelObject->getActiveSheet()->getCell($column.$row)->getValue();
						$client->setEmail($cell);
						break;
					case 'D':
						$cell = $phpExcelObject->getActiveSheet()->getCell($column.$row)->getValue();
						$client->setEntreprise($cell);
						break;
					case 'E':
						$cell = $phpExcelObject->getActiveSheet()->getCell($column.$row)->getValue();
						$date = date('Y-m-d H:i:s', strtotime('01/01/1900' . ' +'.$cell.' day'));
						$datetime = new \DateTime( $date);					
						$client->setDateNaissance($datetime);
						break;
					case 'F':
						$cell = $phpExcelObject->getActiveSheet()->getCell($column.$row)->getValue();
						$client->setCivilite($cell);
						break;
					case 'G':
						$cell = $phpExcelObject->getActiveSheet()->getCell($column.$row)->getValue();
						$client->setVille($cell);
						$cells = $phpExcelObject->getActiveSheet()->getCell('H'.$row)->getValue();
						$pays = $repository->findOneByCountryName($cells);
						$client->setPays($pays);
						
						break;
					default:					
						break;
				}
						    
		    }
		    array_push($dataToRetrun, $client);
		    $client->setIsClient(1);
		    $em->persist($client);
		    $em->flush();
		}

    	
        return $this->render('base.html.twig',array('page'=>'ExcelSend','titre' =>'Excel Inséré','soustitre'=>'Liste des clients inséré','clients'=>$dataToRetrun ));

    }
    public function indexAction(Request $request)
    {
    	$excel = new Excel();
    	$test = "jdksjlfg";
	     $form = $this->createForm('PNL\ExcelToBDDBundle\Form\ExcelType',$excel);
$form->handleRequest($request);
	    if ($form->isSubmitted() && $form->isValid()) {
	    	$excel->preUpload();
	    	$excel->upload($excel->getNom());
	    	
	      $em = $this->getDoctrine()->getManager();
	      $em->persist($excel);
	      $em->flush();
	      $url = $excel->getId();
	      return $this->redirectToRoute('pnl_excel_to_bdd_process',array('path'=>$url));
    }
    return $this->render('base.html.twig',array('page'=>'importExcel','titre' =>'Importation de groupe','soustitre'=>'Ajout d\'un excel','form' => $form->createView()));

}
}
