<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220tpAmb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220tpamb controller.
 *
 * @Route("s2220tpamb")
 */
class S2220tpAmbController extends Controller
{
    /**
     * Lists all s2220tpAmb entities.
     *
     * @Route("/", name="s2220tpamb_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220tpAmbs = $em->getRepository('RHXMLReaderBundle:S2220tpAmb')->findAll();

        return $this->render('s2220tpamb/index.html.twig', array(
            's2220tpAmbs' => $s2220tpAmbs,
        ));
    }

    /**
     * Creates a new s2220tpAmb entity.
     *
     * @Route("/new", name="s2220tpamb_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220tpAmb = new S2220tpamb();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220tpAmbType', $s2220tpAmb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220tpAmb);
            $em->flush();

            return $this->redirectToRoute('s2220tpamb_show', array('id' => $s2220tpAmb->getId()));
        }

        return $this->render('s2220tpamb/new.html.twig', array(
            's2220tpAmb' => $s2220tpAmb,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220tpAmb entity.
     *
     * @Route("/{id}", name="s2220tpamb_show")
     * @Method("GET")
     */
    public function showAction(S2220tpAmb $s2220tpAmb)
    {
        $deleteForm = $this->createDeleteForm($s2220tpAmb);

        return $this->render('s2220tpamb/show.html.twig', array(
            's2220tpAmb' => $s2220tpAmb,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     * @Route("/codigo{codigo}", name="s2220tpamb_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {

        $repositorio = $this->getDoctrine()->getManager()
            ->getRepository('RHXMLReaderBundle:S2220tpAmb');

        $tpAmb = $repositorio->findOneBy(array('codigo' => $codigo));

        if($tpAmb == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }

        return new Response($tpAmb->getDescricao());

    }


    /**
     * Displays a form to edit an existing s2220tpAmb entity.
     *
     * @Route("/{id}/edit", name="s2220tpamb_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220tpAmb $s2220tpAmb)
    {
        $deleteForm = $this->createDeleteForm($s2220tpAmb);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220tpAmbType', $s2220tpAmb);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220tpamb_show', array('id' => $s2220tpAmb->getId()));
        }

        return $this->render('s2220tpamb/edit.html.twig', array(
            's2220tpAmb' => $s2220tpAmb,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220tpAmb entity.
     *
     * @Route("/{id}", name="s2220tpamb_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220tpAmb $s2220tpAmb)
    {
        $form = $this->createDeleteForm($s2220tpAmb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220tpAmb);
            $em->flush();
        }

        return $this->redirectToRoute('s2220tpamb_index');
    }

    /**
     * Creates a form to delete a s2220tpAmb entity.
     *
     * @param S2220tpAmb $s2220tpAmb The s2220tpAmb entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220tpAmb $s2220tpAmb)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220tpamb_delete', array('id' => $s2220tpAmb->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
