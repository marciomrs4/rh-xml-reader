<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\FileFuncionario;
use RH\XMLReaderBundle\Form\FuncionarioImportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class S2240XMLReaderController extends Controller
{
    /**
     * @Route("s2240reader")
     */
    public function readerAction(Request $request)
    {

        $fileAnexo = new FileFuncionario();

        $form = $this->createForm(FuncionarioImportType::class, $fileAnexo);

        $form->handleRequest($request);

        $dados = array();
        $errors = '';

        if($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('file');

            if ($file->getMimeType() == "application/xml") {

                $fileXSD = new File($this->get('kernel')->getRootDir() . '/../web/schemas/S2240.xsd');

                $xmlValidator = $this->get('rhxml_reader.validateXml');

                $xmlValidator->loadFileXml($file);
                $erro = $xmlValidator->validateXml($fileXSD->getRealPath());

                if ($erro) {

                    $errors = $xmlValidator->getAllErrors();

                    return $this->render('RHXMLReaderBundle:S2240XMLReader:reader.html.twig', array(
                        'form' => $form->createView(),
                        's2240' => $dados,
                        'errors' => $errors
                    ));
                }

                $docXml = simplexml_load_file($file);

                //dump($docXml->evtExpRisco); exit();

                $dados = $docXml->evtExpRisco;

            }else{
                $message = ['type' => 'warning', 'message' => 'Arquivo Invalido, somente arquivos XML são aceitos'];

                $this->addFlash('notice', $message);

            }
        }

        return $this->render('RHXMLReaderBundle:S2240XMLReader:reader.html.twig', array(
            'form' => $form->createView(),
            's2240' => $dados,
            'errors' => $errors
        ));
    }


}
