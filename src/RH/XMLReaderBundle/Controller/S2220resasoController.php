<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220resaso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220resaso controller.
 *
 * @Route("s2220resaso")
 */
class S2220resasoController extends Controller
{
    /**
     * Lists all s2220resaso entities.
     *
     * @Route("/", name="s2220resaso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220resasos = $em->getRepository('RHXMLReaderBundle:S2220resaso')->findAll();

        return $this->render('s2220resaso/index.html.twig', array(
            's2220resasos' => $s2220resasos,
        ));
    }

    /**
     * Creates a new s2220resaso entity.
     *
     * @Route("/new", name="s2220resaso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220resaso = new S2220resaso();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220resasoType', $s2220resaso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220resaso);
            $em->flush();

            return $this->redirectToRoute('s2220resaso_show', array('id' => $s2220resaso->getId()));
        }

        return $this->render('s2220resaso/new.html.twig', array(
            's2220resaso' => $s2220resaso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220resaso entity.
     *
     * @Route("/{id}", name="s2220resaso_show")
     * @Method("GET")
     */
    public function showAction(S2220resaso $s2220resaso)
    {
        $deleteForm = $this->createDeleteForm($s2220resaso);

        return $this->render('s2220resaso/show.html.twig', array(
            's2220resaso' => $s2220resaso,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     *
     * @Route("/codigo{codigo}", name="s2220resaso_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $repositorio = $this->getDoctrine()
                            ->getRepository('RHXMLReaderBundle:S2220resaso');

        $resaso = $repositorio->findOneBy(array('codigo' => $codigo));

        if($resaso == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }

        return new Response($resaso->getDescricao());
    }

    /**
     * Displays a form to edit an existing s2220resaso entity.
     *
     * @Route("/{id}/edit", name="s2220resaso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220resaso $s2220resaso)
    {
        $deleteForm = $this->createDeleteForm($s2220resaso);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220resasoType', $s2220resaso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220resaso_show', array('id' => $s2220resaso->getId()));
        }

        return $this->render('s2220resaso/edit.html.twig', array(
            's2220resaso' => $s2220resaso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220resaso entity.
     *
     * @Route("/{id}", name="s2220resaso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220resaso $s2220resaso)
    {
        $form = $this->createDeleteForm($s2220resaso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220resaso);
            $em->flush();
        }

        return $this->redirectToRoute('s2220resaso_index');
    }

    /**
     * Creates a form to delete a s2220resaso entity.
     *
     * @param S2220resaso $s2220resaso The s2220resaso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220resaso $s2220resaso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220resaso_delete', array('id' => $s2220resaso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
