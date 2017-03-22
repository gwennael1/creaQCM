<?php

namespace CreaQCM\QCMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function postAction(Request $request, $id){
        if ($request->isMethod('POST')) {

            $name = $request->request->get('name');
            $checkboxs = $request->request->get('myCheckbox');

            if (empty($checkboxs)){
                return $this->redirectToRoute('crea_qcmqcm_list');
            }

            $eManager = $this->getDoctrine()->getManager();

            $qcm = $eManager->getRepository('CreaQCMQCMBundle:Qcm')->find($id);
            $questions = $qcm->getQuestions()->getValues();

            var_dump($qcm->getId());

            $listResult = array();
            $listSucessError = array();
            foreach ($checkboxs as $key => $checkbox) {
                $listResult[$key-1] = implode(',', $checkbox);
                $response = $questions[$key-1]->getResponse();

                if ($listResult[$key-1] == $response){
                    var_dump(true);
                    $listSucessError[$key-1] = true;
                }
                else{
                    var_dump(false);
                    $listSucessError[$key-1] = false;
                }
            }

            $listQuestion = array();
            foreach ($questions as $key => $question) {

                $listQuestion[$key]['question'] = $question->getAsk();
                $choices = $eManager->getRepository('CreaQCMQCMBundle:Choice')->findBy(array('question' => $question->getId()));

                foreach ($choices as $key2 => $choice) {
                    $listQuestion[$key]['choices'][$key2] = $choice->getValue();
                }

                $listQuestion[$key]['response'] = explode(',',$questions[$key]->getResponse());
            }

            var_dump($listResult);
            var_dump($listSucessError);
            var_dump($listQuestion);
            //var_dump($listQuestion[1]['response']);

            $aListResult = array();
            foreach ($listResult as $key => $result) {
                $aListResult[$key] = explode(',',$result);
            }

            var_dump($aListResult);


            $nbQuestion = sizeof($questions);
            $nbResponseTrue = count(array_filter($listSucessError));
            var_dump($nbQuestion);
            var_dump($nbResponseTrue);

            $note = round(($nbResponseTrue / $nbQuestion) * 20);
            var_dump($note);

            return $this->render('CreaQCMQCMBundle:Answer:result.html.twig', array(
                'name' => $name,
                'note' => $note,
                'qcm' => $qcm,
                'listSucessError' => $listSucessError,
                'listResult' => $aListResult,
                'listQuestion' => $listQuestion
            ));
        }
        else{
            return $this->redirectToRoute('crea_qcmqcm_list');
        }
    }
}
