<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220indRetif;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220indretif controller.
 *
 * @Route("s2220indretif")
 */
class S2220indRetifController extends Controller
{
    /**
     * Lists all s2220indRetif entities.
     *
     * @Route("/", name="s2220indretif_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220indRetifs = $em->getRepository('RHXMLReaderBundle:S2220indRetif')->findAll();

        return $this->render('s2220indretif/index.html.twig', array(
            's2220indRetifs' => $s2220indRetifs,
        ));
    }

    /**
     * Creates a new s2220indRetif entity.
     *
     * @Route("/new", name="s2220indretif_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220indRetif = new S2220indretif();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220indRetifType', $s2220indRetif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220indRetif);
            $em->flush();

            return $this->redirectToRoute('s2220indretif_show', array('id' => $s2220indRetif->getId()));
        }

        return $this->render('s2220indretif/new.html.twig', array(
            's2220indRetif' => $s2220indRetif,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220indRetif entity.
     *
     * @Route("/{id}", name="s2220indretif_show")
     * @Method("GET")
     */
    public function showAction(S2220indRetif $s2220indRetif)
    {
        $deleteForm = $this->createDeleteForm($s2220indRetif);

        return $this->render('s2220indretif/show.html.twig', array(
            's2220indRetif' => $s2220indRetif,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     * @Route("/codigo{codigo}", name="s2220indretif_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $repository = $this->getDoctrine()->getManager()
                   ->getRepository('RHXMLReaderBundle:S2220indRetif');

        $indRetif = $repository->findOneBy(array('codigo' => $codigo));

        if($indRetif == null){
            return new Response('CODIGO NÃO ENCONTRADO');
        }

        return new Response($indRetif->getDescricao());

    }

    /**
     * Displays a form to edit an existing s2220indRetif entity.
     *
     * @Route("/{id}/edit", name="s2220indretif_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220indRetif $s2220indRetif)
    {
        $deleteForm = $this->createDeleteForm($s2220indRetif);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220indRetifType', $s2220indRetif);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220indretif_show', array('id' => $s2220indRetif->getId()));
        }

        return $this->render('s2220indretif/edit.html.twig', array(
            's2220indRetif' => $s2220indRetif,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220indRetif entity.
     *
     * @Route("/{id}", name="s2220indretif_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220indRetif $s2220indRetif)
    {
        $form = $this->createDeleteForm($s2220indRetif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220indRetif);
            $em->flush();
        }

        return $this->redirectToRoute('s2220indretif_index');
    }

    /**
     * Creates a form to delete a s2220indRetif entity.
     *
     * @param S2220indRetif $s2220indRetif The s2220indRetif entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220indRetif $s2220indRetif)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220indretif_delete', array('id' => $s2220indRetif->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
