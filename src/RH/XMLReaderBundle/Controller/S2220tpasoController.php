<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220tpaso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220tpaso controller.
 *
 * @Route("s2220tpaso")
 */
class S2220tpasoController extends Controller
{
    /**
     * Lists all s2220tpaso entities.
     *
     * @Route("/", name="s2220tpaso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220tpasos = $em->getRepository('RHXMLReaderBundle:S2220tpaso')->findAll();

        return $this->render('s2220tpaso/index.html.twig', array(
            's2220tpasos' => $s2220tpasos,
        ));
    }

    /**
     * Creates a new s2220tpaso entity.
     *
     * @Route("/new", name="s2220tpaso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220tpaso = new S2220tpaso();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220tpasoType', $s2220tpaso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220tpaso);
            $em->flush();

            return $this->redirectToRoute('s2220tpaso_show', array('id' => $s2220tpaso->getId()));
        }

        return $this->render('s2220tpaso/new.html.twig', array(
            's2220tpaso' => $s2220tpaso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220tpaso entity.
     *
     * @Route("/{id}", name="s2220tpaso_show")
     * @Method("GET")
     */
    public function showAction(S2220tpaso $s2220tpaso)
    {
        $deleteForm = $this->createDeleteForm($s2220tpaso);

        return $this->render('s2220tpaso/show.html.twig', array(
            's2220tpaso' => $s2220tpaso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     * @Route("codigo/{codigo}", name="s2220tpaso_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
            $repositorio = $this->getDoctrine()
                                ->getRepository('RHXMLReaderBundle:S2220tpaso');

            $tpaso = $repositorio->findOneBy(array('codigo' => $codigo));

        if($tpaso == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }

        return new Response($tpaso->getDescricao());
    }

    /**
     * Displays a form to edit an existing s2220tpaso entity.
     *
     * @Route("/{id}/edit", name="s2220tpaso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220tpaso $s2220tpaso)
    {
        $deleteForm = $this->createDeleteForm($s2220tpaso);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220tpasoType', $s2220tpaso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220tpaso_show', array('id' => $s2220tpaso->getId()));
        }

        return $this->render('s2220tpaso/edit.html.twig', array(
            's2220tpaso' => $s2220tpaso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220tpaso entity.
     *
     * @Route("/{id}", name="s2220tpaso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220tpaso $s2220tpaso)
    {
        $form = $this->createDeleteForm($s2220tpaso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220tpaso);
            $em->flush();
        }

        return $this->redirectToRoute('s2220tpaso_index');
    }

    /**
     * Creates a form to delete a s2220tpaso entity.
     *
     * @param S2220tpaso $s2220tpaso The s2220tpaso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220tpaso $s2220tpaso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220tpaso_delete', array('id' => $s2220tpaso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
