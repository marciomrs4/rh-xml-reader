<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2240utilizepi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;use Symfony\Component\HttpFoundation\Request;

/**
 * S2240utilizepi controller.
 *
 * @Route("s2240utilizepi")
 */
class S2240utilizepiController extends Controller
{
    /**
     * Lists all s2240utilizepi entities.
     *
     * @Route("/", name="s2240utilizepi_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2240utilizepis = $em->getRepository('RHXMLReaderBundle:S2240utilizepi')->findAll();

        return $this->render('s2240utilizepi/index.html.twig', array(
            's2240utilizepis' => $s2240utilizepis,
        ));
    }

    /**
     * Creates a new s2240utilizepi entity.
     *
     * @Route("/new", name="s2240utilizepi_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2240utilizepi = new S2240utilizepi();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2240utilizepiType', $s2240utilizepi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2240utilizepi);
            $em->flush();

            return $this->redirectToRoute('s2240utilizepi_show', array('id' => $s2240utilizepi->getId()));
        }

        return $this->render('s2240utilizepi/new.html.twig', array(
            's2240utilizepi' => $s2240utilizepi,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2240utilizepi entity.
     *
     * @Route("/{id}", name="s2240utilizepi_show")
     * @Method("GET")
     */
    public function showAction(S2240utilizepi $s2240utilizepi)
    {
        $deleteForm = $this->createDeleteForm($s2240utilizepi);

        return $this->render('s2240utilizepi/show.html.twig', array(
            's2240utilizepi' => $s2240utilizepi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing s2240utilizepi entity.
     *
     * @Route("/{id}/edit", name="s2240utilizepi_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2240utilizepi $s2240utilizepi)
    {
        $deleteForm = $this->createDeleteForm($s2240utilizepi);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2240utilizepiType', $s2240utilizepi);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2240utilizepi_show', array('id' => $s2240utilizepi->getId()));
        }

        return $this->render('s2240utilizepi/edit.html.twig', array(
            's2240utilizepi' => $s2240utilizepi,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2240utilizepi entity.
     *
     * @Route("/{id}", name="s2240utilizepi_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2240utilizepi $s2240utilizepi)
    {
        $form = $this->createDeleteForm($s2240utilizepi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2240utilizepi);
            $em->flush();
        }

        return $this->redirectToRoute('s2240utilizepi_index');
    }

    /**
     * Creates a form to delete a s2240utilizepi entity.
     *
     * @param S2240utilizepi $s2240utilizepi The s2240utilizepi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2240utilizepi $s2240utilizepi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2240utilizepi_delete', array('id' => $s2240utilizepi->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * Finds and displays a log s2240utilizepi entity.
     *
     * @Route("/log/{id}", name="s2240utilizepi_log")
     * @Method("GET")
     */
    public function logAction(S2240utilizepi $s2240utilizepi)
    {
        $log = $this->getDoctrine()
        ->getRepository('Gedmo:LogEntry')
        ->getLogEntries($s2240utilizepi);


        return $this->render('s2240utilizepi/log.html.twig', array(
            's2240utilizepi' => $s2240utilizepi,
            'log' => $log

        ));
    }

    
    /**
     * Finds and displays a log s2240utilizepi entity.
     *
     * @Route("/codigo/{codigo}", name="s2240utilizepi_text")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $entity = $this->getDoctrine()
        ->getRepository('RHXMLReaderBundle:S2240utilizepi')
        ->findOneBy(array('codigo' => $codigo));

        if($entity == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }


        return new Response($entity->getDescricao());
    }

}
