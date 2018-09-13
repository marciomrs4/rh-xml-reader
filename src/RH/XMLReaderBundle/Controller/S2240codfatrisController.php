<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2240codfatris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;use Symfony\Component\HttpFoundation\Request;

/**
 * S2240codfatri controller.
 *
 * @Route("s2240codfatris")
 */
class S2240codfatrisController extends Controller
{
    /**
     * Lists all s2240codfatri entities.
     *
     * @Route("/", name="s2240codfatris_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2240codfatris = $em->getRepository('RHXMLReaderBundle:S2240codfatris')->findAll();

        return $this->render('s2240codfatris/index.html.twig', array(
            's2240codfatris' => $s2240codfatris,
        ));
    }

    /**
     * Creates a new s2240codfatri entity.
     *
     * @Route("/new", name="s2240codfatris_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2240codfatri = new S2240codfatris();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2240codfatrisType', $s2240codfatri);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2240codfatri);
            $em->flush();

            return $this->redirectToRoute('s2240codfatris_show', array('id' => $s2240codfatri->getId()));
        }

        return $this->render('s2240codfatris/new.html.twig', array(
            's2240codfatri' => $s2240codfatri,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2240codfatri entity.
     *
     * @Route("/{id}", name="s2240codfatris_show")
     * @Method("GET")
     */
    public function showAction(S2240codfatris $s2240codfatri)
    {
        $deleteForm = $this->createDeleteForm($s2240codfatri);

        return $this->render('s2240codfatris/show.html.twig', array(
            's2240codfatri' => $s2240codfatri,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing s2240codfatri entity.
     *
     * @Route("/{id}/edit", name="s2240codfatris_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2240codfatris $s2240codfatri)
    {
        $deleteForm = $this->createDeleteForm($s2240codfatri);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2240codfatrisType', $s2240codfatri);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2240codfatris_show', array('id' => $s2240codfatri->getId()));
        }

        return $this->render('s2240codfatris/edit.html.twig', array(
            's2240codfatri' => $s2240codfatri,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2240codfatri entity.
     *
     * @Route("/{id}", name="s2240codfatris_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2240codfatris $s2240codfatri)
    {
        $form = $this->createDeleteForm($s2240codfatri);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2240codfatri);
            $em->flush();
        }

        return $this->redirectToRoute('s2240codfatris_index');
    }

    /**
     * Creates a form to delete a s2240codfatri entity.
     *
     * @param S2240codfatris $s2240codfatri The s2240codfatri entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2240codfatris $s2240codfatri)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2240codfatris_delete', array('id' => $s2240codfatri->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    
    /**
     * Finds and displays a log s2240codfatri entity.
     *
     * @Route("/log/{id}", name="s2240codfatris_log")
     * @Method("GET")
     */
    public function logAction(S2240codfatris $s2240codfatri)
    {
        $log = $this->getDoctrine()
        ->getRepository('Gedmo:LogEntry')
        ->getLogEntries($s2240codfatri);


        return $this->render('s2240codfatris/log.html.twig', array(
            's2240codfatri' => $s2240codfatri,
            'log' => $log

        ));
    }

    
    /**
     * Finds and displays a log s2240codfatri entity.
     *
     * @Route("/codigo/{codigo}", name="s2240codfatris_text")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $entity = $this->getDoctrine()
        ->getRepository('RHXMLReaderBundle:S2240codfatris')
        ->findOneBy(array('codigo' => $codigo));

        if($entity == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }


        return new Response($entity->getDescricao());
    }

}
