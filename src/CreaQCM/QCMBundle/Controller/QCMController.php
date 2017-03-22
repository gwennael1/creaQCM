<?php

namespace CreaQCM\QCMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QCMController extends Controller
{
    public function indexAction()
    {
        return $this->render('CreaQCMQCMBundle::layout.html.twig');
    }

    public function listAction()
    {
        $eManager = $this->getDoctrine()->getManager();
        $listQCM = $eManager->getRepository('CreaQCMQCMBundle:Qcm')->findAll();


        return $this->render('CreaQCMQCMBundle:Qcm:list.html.twig', array('listQCM' => $listQCM));
    }

    public function answerAction()
    {
        $eManager = $this->getDoctrine()->getManager();
        $listQCM = $eManager->getRepository('CreaQCMQCMBundle:Qcm')->findAll();

        var_dump($listQCM);


        //return $this->render('CreaQCMQCMBundle:Qcm:list.html.twig', array('listQCM' => $listQCM));
    }
}
