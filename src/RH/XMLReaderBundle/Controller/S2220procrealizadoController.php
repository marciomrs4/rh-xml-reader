<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220procrealizado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use RH\XMLReaderBundle\Form\FuncionarioImportType;
use RH\XMLReaderBundle\Entity\FileFuncionario;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220procrealizado controller.
 *
 * @Route("s2220procrealizado")
 */
class S2220procrealizadoController extends Controller
{
    /**
     * Lists all s2220procrealizado entities.
     *
     * @Route("/", name="s2220procrealizado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220procrealizados = $em->getRepository('RHXMLReaderBundle:S2220procrealizado')->findAll();

        return $this->render('s2220procrealizado/index.html.twig', array(
            's2220procrealizados' => $s2220procrealizados,
        ));
    }

    /**
     * Displays a form to edit an existing funcionario entity.
     *
     * @Route("/import", name="s2220procrealizado_import")
     * @Method({"GET", "POST"})
     */
    public function importAction(Request $request)
    {

        $fileAnexo = new FileFuncionario();

        $form = $this->createForm(FuncionarioImportType::class, $fileAnexo);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $file = '';

            $file = $request->files->get('file');
            $coluna = array();

            if ($file) {

                $em = $this->getDoctrine()->getManager();

                $linhas = file($file);


                foreach ($linhas as $linha) {

                    $coluna = explode(';', $linha);

                    $s2220ProcRealizado = new S2220procrealizado();

                    $s2220ProcRealizado->setCodigo($coluna[0])
                        ->setDescricao($coluna[1]);

                    $em->persist($s2220ProcRealizado);

                }

                $em->flush();
            }

        }

        return $this->render('s2220procrealizado/import.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * Creates a new s2220procrealizado entity.
     *
     * @Route("/new", name="s2220procrealizado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220procrealizado = new S2220procrealizado();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220procrealizadoType', $s2220procrealizado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220procrealizado);
            $em->flush();

            return $this->redirectToRoute('s2220procrealizado_show', array('id' => $s2220procrealizado->getId()));
        }

        return $this->render('s2220procrealizado/new.html.twig', array(
            's2220procrealizado' => $s2220procrealizado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220procrealizado entity.
     *
     * @Route("/{id}", name="s2220procrealizado_show")
     * @Method("GET")
     */
    public function showAction(S2220procrealizado $s2220procrealizado)
    {
        $deleteForm = $this->createDeleteForm($s2220procrealizado);

        return $this->render('s2220procrealizado/show.html.twig', array(
            's2220procrealizado' => $s2220procrealizado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     * @Route("/codigo{codigo}", name="s2220procrealizado_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $repositorio = $this->getDoctrine()
                            ->getRepository('RHXMLReaderBundle:S2220procrealizado');

        $procRealizado =$repositorio->findOneBy(array('codigo' => $codigo));

        if($procRealizado == null){
            return new Response('CODIGO NÃO ENCONTRADO: '. $codigo);
        }

        return new Response($procRealizado->getDescricao());

    }

    /**
     * Displays a form to edit an existing s2220procrealizado entity.
     *
     * @Route("/{id}/edit", name="s2220procrealizado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220procrealizado $s2220procrealizado)
    {
        $deleteForm = $this->createDeleteForm($s2220procrealizado);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220procrealizadoType', $s2220procrealizado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220procrealizado_show', array('id' => $s2220procrealizado->getId()));
        }

        return $this->render('s2220procrealizado/edit.html.twig', array(
            's2220procrealizado' => $s2220procrealizado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220procrealizado entity.
     *
     * @Route("/{id}", name="s2220procrealizado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220procrealizado $s2220procrealizado)
    {
        $form = $this->createDeleteForm($s2220procrealizado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220procrealizado);
            $em->flush();
        }

        return $this->redirectToRoute('s2220procrealizado_index');
    }

    /**
     * Creates a form to delete a s2220procrealizado entity.
     *
     * @param S2220procrealizado $s2220procrealizado The s2220procrealizado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220procrealizado $s2220procrealizado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220procrealizado_delete', array('id' => $s2220procrealizado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
