<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2240codamb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;use Symfony\Component\HttpFoundation\Request;

/**
 * S2240codamb controller.
 *
 * @Route("s2240codamb")
 */
class S2240codambController extends Controller
{
    /**
     * Lists all s2240codamb entities.
     *
     * @Route("/", name="s2240codamb_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2240codambs = $em->getRepository('RHXMLReaderBundle:S2240codamb')->findAll();

        return $this->render('s2240codamb/index.html.twig', array(
            's2240codambs' => $s2240codambs,
        ));
    }

    /**
     * Creates a new s2240codamb entity.
     *
     * @Route("/new", name="s2240codamb_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2240codamb = new S2240codamb();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2240codambType', $s2240codamb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2240codamb);
            $em->flush();

            return $this->redirectToRoute('s2240codamb_show', array('id' => $s2240codamb->getId()));
        }

        return $this->render('s2240codamb/new.html.twig', array(
            's2240codamb' => $s2240codamb,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2240codamb entity.
     *
     * @Route("/{id}", name="s2240codamb_show")
     * @Method("GET")
     */
    public function showAction(S2240codamb $s2240codamb)
    {
        $deleteForm = $this->createDeleteForm($s2240codamb);

        return $this->render('s2240codamb/show.html.twig', array(
            's2240codamb' => $s2240codamb,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing s2240codamb entity.
     *
     * @Route("/{id}/edit", name="s2240codamb_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2240codamb $s2240codamb)
    {
        $deleteForm = $this->createDeleteForm($s2240codamb);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2240codambType', $s2240codamb);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2240codamb_show', array('id' => $s2240codamb->getId()));
        }

        return $this->render('s2240codamb/edit.html.twig', array(
            's2240codamb' => $s2240codamb,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2240codamb entity.
     *
     * @Route("/{id}", name="s2240codamb_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2240codamb $s2240codamb)
    {
        $form = $this->createDeleteForm($s2240codamb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2240codamb);
            $em->flush();
        }

        return $this->redirectToRoute('s2240codamb_index');
    }

    /**
     * Creates a form to delete a s2240codamb entity.
     *
     * @param S2240codamb $s2240codamb The s2240codamb entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2240codamb $s2240codamb)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2240codamb_delete', array('id' => $s2240codamb->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * Finds and displays a log s2240codamb entity.
     *
     * @Route("/log/{id}", name="s2240codamb_log")
     * @Method("GET")
     */
    public function logAction(S2240codamb $s2240codamb)
    {
        $log = $this->getDoctrine()
        ->getRepository('Gedmo:LogEntry')
        ->getLogEntries($s2240codamb);


        return $this->render('s2240codamb/log.html.twig', array(
            's2240codamb' => $s2240codamb,
            'log' => $log

        ));
    }

    
    /**
     * Finds and displays a log s2240codamb entity.
     *
     * @Route("/codigo/{codigo}", name="s2240codamb_text")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $entity = $this->getDoctrine()
        ->getRepository('RHXMLReaderBundle:S2240codamb')
        ->findOneBy(array('codigo' => $codigo));

        if($entity == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }


        return new Response($entity->getDescricao());
    }

}
