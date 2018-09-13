<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220eS2240SimNao;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;use Symfony\Component\HttpFoundation\Request;

/**
 * S2220es2240simnao controller.
 *
 * @Route("s2220es2240simnao")
 */
class S2220eS2240SimNaoController extends Controller
{
    /**
     * Lists all s2220eS2240SimNao entities.
     *
     * @Route("/", name="s2220es2240simnao_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220eS2240SimNaos = $em->getRepository('RHXMLReaderBundle:S2220eS2240SimNao')->findAll();

        return $this->render('s2220es2240simnao/index.html.twig', array(
            's2220eS2240SimNaos' => $s2220eS2240SimNaos,
        ));
    }

    /**
     * Creates a new s2220eS2240SimNao entity.
     *
     * @Route("/new", name="s2220es2240simnao_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220eS2240SimNao = new S2220es2240simnao();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220eS2240SimNaoType', $s2220eS2240SimNao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220eS2240SimNao);
            $em->flush();

            return $this->redirectToRoute('s2220es2240simnao_show', array('id' => $s2220eS2240SimNao->getId()));
        }

        return $this->render('s2220es2240simnao/new.html.twig', array(
            's2220eS2240SimNao' => $s2220eS2240SimNao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220eS2240SimNao entity.
     *
     * @Route("/{id}", name="s2220es2240simnao_show")
     * @Method("GET")
     */
    public function showAction(S2220eS2240SimNao $s2220eS2240SimNao)
    {
        $deleteForm = $this->createDeleteForm($s2220eS2240SimNao);

        return $this->render('s2220es2240simnao/show.html.twig', array(
            's2220eS2240SimNao' => $s2220eS2240SimNao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing s2220eS2240SimNao entity.
     *
     * @Route("/{id}/edit", name="s2220es2240simnao_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220eS2240SimNao $s2220eS2240SimNao)
    {
        $deleteForm = $this->createDeleteForm($s2220eS2240SimNao);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220eS2240SimNaoType', $s2220eS2240SimNao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220es2240simnao_show', array('id' => $s2220eS2240SimNao->getId()));
        }

        return $this->render('s2220es2240simnao/edit.html.twig', array(
            's2220eS2240SimNao' => $s2220eS2240SimNao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220eS2240SimNao entity.
     *
     * @Route("/{id}", name="s2220es2240simnao_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220eS2240SimNao $s2220eS2240SimNao)
    {
        $form = $this->createDeleteForm($s2220eS2240SimNao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220eS2240SimNao);
            $em->flush();
        }

        return $this->redirectToRoute('s2220es2240simnao_index');
    }

    /**
     * Creates a form to delete a s2220eS2240SimNao entity.
     *
     * @param S2220eS2240SimNao $s2220eS2240SimNao The s2220eS2240SimNao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220eS2240SimNao $s2220eS2240SimNao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220es2240simnao_delete', array('id' => $s2220eS2240SimNao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * Finds and displays a log s2220eS2240SimNao entity.
     *
     * @Route("/log/{id}", name="s2220es2240simnao_log")
     * @Method("GET")
     */
    public function logAction(S2220eS2240SimNao $s2220eS2240SimNao)
    {
        $log = $this->getDoctrine()
        ->getRepository('Gedmo:LogEntry')
        ->getLogEntries($s2220eS2240SimNao);


        return $this->render('s2220es2240simnao/log.html.twig', array(
            's2220eS2240SimNao' => $s2220eS2240SimNao,
            'log' => $log

        ));
    }

    
    /**
     * Finds and displays a log s2220eS2240SimNao entity.
     *
     * @Route("/codigo/{codigo}", name="s2220es2240simnao_text")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $entity = $this->getDoctrine()
        ->getRepository('RHXMLReaderBundle:S2220eS2240SimNao')
        ->findOneBy(array('codigo' => $codigo));

        if($entity == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }


        return new Response($entity->getDescricao());
    }

}
