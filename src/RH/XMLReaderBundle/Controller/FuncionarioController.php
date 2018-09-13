<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\FileFuncionario;
use RH\XMLReaderBundle\Entity\Funcionario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RH\XMLReaderBundle\Form\FuncionarioImportType;

/**
 * Funcionario controller.
 *
 * @Route("funcionario")
 */
class FuncionarioController extends Controller
{
    /**
     * Lists all funcionario entities.
     *
     * @Route("/", name="funcionario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $funcionarios = $em->getRepository('RHXMLReaderBundle:Funcionario')->findAll();

        return $this->render('funcionario/index.html.twig', array(
            'funcionarios' => $funcionarios,
        ));
    }

    /**
     * Displays a form to edit an existing funcionario entity.
     *
     * @Route("/import", name="funcionario_import")
     * @Method({"GET", "POST"})
     */
    public function importAction(Request $request)
    {

        $fileAnexo = new FileFuncionario();

        $form = $this->createForm(FuncionarioImportType::class, $fileAnexo);

        $form->handleRequest($request);

        $usuariosJaExistentes = array();

        $usuariosInseridos = array();

        if($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('file');

            if ($file->getMimeType() == "text/plain") {

                $em = $this->getDoctrine()->getManager();

                $linhas = file($file);

                $funcionario = $this->getDoctrine()
                    ->getRepository('RHXMLReaderBundle:Funcionario');


                foreach ($linhas as $linha) {

                    $coluna = explode(';', $linha);

                    if(count($coluna) != 4){

                        $message = ['type' => 'warning', 'message' => 'Arquivo Invalido, devem haver 4 colunas no arquivo.'];

                        $this->addFlash('notice', $message);
                        return $this->redirectToRoute('funcionario_import');
                    }


                    if(is_numeric($coluna[2])){

                        $funcionarioExistente = $funcionario->consultaCPF($coluna[2]);

                        if ($funcionarioExistente) {

                            $usuariosJaExistentes[] = $funcionarioExistente;

                            $funcionarioExistente->setNome($coluna[1])
                                ->setCpf($coluna[2])
                                ->setDrt($coluna[0])
                                ->setPis($coluna[3])
                                ->setStatus(true);

                            $funcionario->updateFuncionario($funcionarioExistente);
                            $em->flush();

                        } else {

                            $funcionario->insertFuncionario($coluna);
                            $em->flush();

                            $usuariosInseridos[] = $coluna;
                        }
                    }

                }

                $em->flush();


            } else {

                $message = ['type' => 'warning', 'message' => 'Arquivo Invalido, somente arquivos CSV são aceitos'];

                $this->addFlash('notice', $message);

            }
        }

        return $this->render(':funcionario:import.html.twig',[
            'form' => $form->createView(),
            'usuarioInseridos' => $usuariosInseridos,
            'usuariosJaExistentes' => $usuariosJaExistentes
        ]);

    }



    /**
     * Creates a new funcionario entity.
     *
     * @Route("/new", name="funcionario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $funcionario = new Funcionario();
        $form = $this->createForm('RH\XMLReaderBundle\Form\FuncionarioType', $funcionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($funcionario);
            $em->flush();

            return $this->redirectToRoute('funcionario_show', array('id' => $funcionario->getId()));
        }

        return $this->render('funcionario/new.html.twig', array(
            'funcionario' => $funcionario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a funcionario entity.
     *
     * @Route("/{id}", name="funcionario_show")
     * @Method("GET")
     */
    public function showAction(Funcionario $funcionario)
    {
        $deleteForm = $this->createDeleteForm($funcionario);

        return $this->render('funcionario/show.html.twig', array(
            'funcionario' => $funcionario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a funcionario entity.
     *
     * @Route("/cpf/{cpf}", name="funcionario_cpf_show")
     * @Method("GET")
     */
    public function cpfShowAction($cpf = null)
    {

        $em = $this->getDoctrine()->getManager();

        $funcionario = $em->getRepository('RHXMLReaderBundle:Funcionario')
            ->findOneBy(array('cpf' => $cpf));

        if($funcionario == null){
            return new Response('CPF NAO ENCONTRADO');
        }

        return new Response($funcionario->getNome());

        //return new JsonResponse($funcionario->getNome());

    }


    /**
     * Displays a form to edit an existing funcionario entity.
     *
     * @Route("/{id}/edit", name="funcionario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Funcionario $funcionario)
    {
        $deleteForm = $this->createDeleteForm($funcionario);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\FuncionarioType', $funcionario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('funcionario_show', array('id' => $funcionario->getId()));
        }

        return $this->render('funcionario/edit.html.twig', array(
            'funcionario' => $funcionario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a funcionario entity.
     *
     * @Route("/{id}", name="funcionario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Funcionario $funcionario)
    {
        $form = $this->createDeleteForm($funcionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($funcionario);
            $em->flush();
        }

        return $this->redirectToRoute('funcionario_index');
    }

    /**
     * Creates a form to delete a funcionario entity.
     *
     * @param Funcionario $funcionario The funcionario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Funcionario $funcionario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('funcionario_delete', array('id' => $funcionario->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Finds and displays a log s2220interprexm entity.
     *
     * @Route("/log/{id}", name="funcionario_log")
     * @Method("GET")
     */
    public function logAction(Funcionario $funcionario)
    {
        $log = $this->getDoctrine()
            ->getRepository('Gedmo:LogEntry')
            ->getLogEntries($funcionario);


        return $this->render('funcionario/log.html.twig', array(
            'funcionario' => $funcionario,
            'log' => $log

        ));
    }
}
