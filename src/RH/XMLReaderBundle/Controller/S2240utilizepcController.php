<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2240utilizepc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;use Symfony\Component\HttpFoundation\Request;

/**
 * S2240utilizepc controller.
 *
 * @Route("s2240utilizepc")
 */
class S2240utilizepcController extends Controller
{
    /**
     * Lists all s2240utilizepc entities.
     *
     * @Route("/", name="s2240utilizepc_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2240utilizepcs = $em->getRepository('RHXMLReaderBundle:S2240utilizepc')->findAll();

        return $this->render('s2240utilizepc/index.html.twig', array(
            's2240utilizepcs' => $s2240utilizepcs,
        ));
    }

    /**
     * Creates a new s2240utilizepc entity.
     *
     * @Route("/new", name="s2240utilizepc_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2240utilizepc = new S2240utilizepc();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2240utilizepcType', $s2240utilizepc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2240utilizepc);
            $em->flush();

            return $this->redirectToRoute('s2240utilizepc_show', array('id' => $s2240utilizepc->getId()));
        }

        return $this->render('s2240utilizepc/new.html.twig', array(
            's2240utilizepc' => $s2240utilizepc,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2240utilizepc entity.
     *
     * @Route("/{id}", name="s2240utilizepc_show")
     * @Method("GET")
     */
    public function showAction(S2240utilizepc $s2240utilizepc)
    {
        $deleteForm = $this->createDeleteForm($s2240utilizepc);

        return $this->render('s2240utilizepc/show.html.twig', array(
            's2240utilizepc' => $s2240utilizepc,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing s2240utilizepc entity.
     *
     * @Route("/{id}/edit", name="s2240utilizepc_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2240utilizepc $s2240utilizepc)
    {
        $deleteForm = $this->createDeleteForm($s2240utilizepc);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2240utilizepcType', $s2240utilizepc);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2240utilizepc_show', array('id' => $s2240utilizepc->getId()));
        }

        return $this->render('s2240utilizepc/edit.html.twig', array(
            's2240utilizepc' => $s2240utilizepc,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2240utilizepc entity.
     *
     * @Route("/{id}", name="s2240utilizepc_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2240utilizepc $s2240utilizepc)
    {
        $form = $this->createDeleteForm($s2240utilizepc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2240utilizepc);
            $em->flush();
        }

        return $this->redirectToRoute('s2240utilizepc_index');
    }

    /**
     * Creates a form to delete a s2240utilizepc entity.
     *
     * @param S2240utilizepc $s2240utilizepc The s2240utilizepc entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2240utilizepc $s2240utilizepc)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2240utilizepc_delete', array('id' => $s2240utilizepc->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * Finds and displays a log s2240utilizepc entity.
     *
     * @Route("/log/{id}", name="s2240utilizepc_log")
     * @Method("GET")
     */
    public function logAction(S2240utilizepc $s2240utilizepc)
    {
        $log = $this->getDoctrine()
        ->getRepository('Gedmo:LogEntry')
        ->getLogEntries($s2240utilizepc);


        return $this->render('s2240utilizepc/log.html.twig', array(
            's2240utilizepc' => $s2240utilizepc,
            'log' => $log

        ));
    }

    
    /**
     * Finds and displays a log s2240utilizepc entity.
     *
     * @Route("/codigo/{codigo}", name="s2240utilizepc_text")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $entity = $this->getDoctrine()
        ->getRepository('RHXMLReaderBundle:S2240utilizepc')
        ->findOneBy(array('codigo' => $codigo));

        if($entity == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }


        return new Response($entity->getDescricao());
    }

}
