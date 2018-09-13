<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220procemi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220procemi controller.
 *
 * @Route("s2220procemi")
 */
class S2220procemiController extends Controller
{
    /**
     * Lists all s2220procemi entities.
     *
     * @Route("/", name="s2220procemi_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220procemis = $em->getRepository('RHXMLReaderBundle:S2220procemi')->findAll();

        return $this->render('s2220procemi/index.html.twig', array(
            's2220procemis' => $s2220procemis,
        ));
    }

    /**
     * Creates a new s2220procemi entity.
     *
     * @Route("/new", name="s2220procemi_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220procemi = new S2220procemi();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220procemiType', $s2220procemi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220procemi);
            $em->flush();

            return $this->redirectToRoute('s2220procemi_show', array('id' => $s2220procemi->getId()));
        }

        return $this->render('s2220procemi/new.html.twig', array(
            's2220procemi' => $s2220procemi,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220procemi entity.
     *
     * @Route("/{id}", name="s2220procemi_show")
     * @Method("GET")
     */
    public function showAction(S2220procemi $s2220procemi)
    {
        $deleteForm = $this->createDeleteForm($s2220procemi);

        return $this->render('s2220procemi/show.html.twig', array(
            's2220procemi' => $s2220procemi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     * @Route("/codigo{codigo}", name="s2220procemi_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $repositorio = $this->getDoctrine()->getManager()
            ->getRepository('RHXMLReaderBundle:S2220procemi');

        $procemi = $repositorio->findOneBy(array('codigo' => $codigo));

        if($procemi == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }

        return new Response($procemi->getDescricao());
    }


    /**
     * Displays a form to edit an existing s2220procemi entity.
     *
     * @Route("/{id}/edit", name="s2220procemi_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220procemi $s2220procemi)
    {
        $deleteForm = $this->createDeleteForm($s2220procemi);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220procemiType', $s2220procemi);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220procemi_show', array('id' => $s2220procemi->getId()));
        }

        return $this->render('s2220procemi/edit.html.twig', array(
            's2220procemi' => $s2220procemi,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220procemi entity.
     *
     * @Route("/{id}", name="s2220procemi_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220procemi $s2220procemi)
    {
        $form = $this->createDeleteForm($s2220procemi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220procemi);
            $em->flush();
        }

        return $this->redirectToRoute('s2220procemi_index');
    }

    /**
     * Creates a form to delete a s2220procemi entity.
     *
     * @param S2220procemi $s2220procemi The s2220procemi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220procemi $s2220procemi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220procemi_delete', array('id' => $s2220procemi->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
