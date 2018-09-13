<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220interprexm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;use Symfony\Component\HttpFoundation\Request;

/**
 * S2220interprexm controller.
 *
 * @Route("s2220interprexm")
 */
class S2220interprexmController extends Controller
{
    /**
     * Lists all s2220interprexm entities.
     *
     * @Route("/", name="s2220interprexm_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220interprexms = $em->getRepository('RHXMLReaderBundle:S2220interprexm')->findAll();

        return $this->render('s2220interprexm/index.html.twig', array(
            's2220interprexms' => $s2220interprexms,
        ));
    }

    /**
     * Creates a new s2220interprexm entity.
     *
     * @Route("/new", name="s2220interprexm_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220interprexm = new S2220interprexm();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220interprexmType', $s2220interprexm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220interprexm);
            $em->flush();

            return $this->redirectToRoute('s2220interprexm_show', array('id' => $s2220interprexm->getId()));
        }

        return $this->render('s2220interprexm/new.html.twig', array(
            's2220interprexm' => $s2220interprexm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220interprexm entity.
     *
     * @Route("/{id}", name="s2220interprexm_show")
     * @Method("GET")
     */
    public function showAction(S2220interprexm $s2220interprexm)
    {
        $deleteForm = $this->createDeleteForm($s2220interprexm);

        return $this->render('s2220interprexm/show.html.twig', array(
            's2220interprexm' => $s2220interprexm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing s2220interprexm entity.
     *
     * @Route("/{id}/edit", name="s2220interprexm_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220interprexm $s2220interprexm)
    {
        $deleteForm = $this->createDeleteForm($s2220interprexm);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220interprexmType', $s2220interprexm);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220interprexm_show', array('id' => $s2220interprexm->getId()));
        }

        return $this->render('s2220interprexm/edit.html.twig', array(
            's2220interprexm' => $s2220interprexm,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220interprexm entity.
     *
     * @Route("/{id}", name="s2220interprexm_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220interprexm $s2220interprexm)
    {
        $form = $this->createDeleteForm($s2220interprexm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220interprexm);
            $em->flush();
        }

        return $this->redirectToRoute('s2220interprexm_index');
    }

    /**
     * Creates a form to delete a s2220interprexm entity.
     *
     * @param S2220interprexm $s2220interprexm The s2220interprexm entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220interprexm $s2220interprexm)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220interprexm_delete', array('id' => $s2220interprexm->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * Finds and displays a log s2220interprexm entity.
     *
     * @Route("/log/{id}", name="s2220interprexm_log")
     * @Method("GET")
     */
    public function logAction(S2220interprexm $s2220interprexm)
    {
        $log = $this->getDoctrine()
        ->getRepository('Gedmo:LogEntry')
        ->getLogEntries($s2220interprexm);


        return $this->render('s2220interprexm/log.html.twig', array(
            's2220interprexm' => $s2220interprexm,
            'log' => $log

        ));
    }

    
    /**
     * Finds and displays a log s2220interprexm entity.
     *
     * @Route("/codigo/{codigo}", name="s2220interprexm_text")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $entity = $this->getDoctrine()
        ->getRepository('RHXMLReaderBundle:S2220interprexm')
        ->findOneBy(array('codigo' => $codigo));

        if($entity == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }


        return new Response($entity->getDescricao());
    }

}
