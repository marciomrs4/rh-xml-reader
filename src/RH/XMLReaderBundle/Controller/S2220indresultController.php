<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220indresult;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220indresult controller.
 *
 * @Route("s2220indresult")
 */
class S2220indresultController extends Controller
{
    /**
     * Lists all s2220indresult entities.
     *
     * @Route("/", name="s2220indresult_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220indresults = $em->getRepository('RHXMLReaderBundle:S2220indresult')->findAll();

        return $this->render('s2220indresult/index.html.twig', array(
            's2220indresults' => $s2220indresults,
        ));
    }

    /**
     * Creates a new s2220indresult entity.
     *
     * @Route("/new", name="s2220indresult_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220indresult = new S2220indresult();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220indresultType', $s2220indresult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220indresult);
            $em->flush();

            return $this->redirectToRoute('s2220indresult_show', array('id' => $s2220indresult->getId()));
        }

        return $this->render('s2220indresult/new.html.twig', array(
            's2220indresult' => $s2220indresult,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/codigo/{codigo}", name="s2220indresult_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo = null)
    {
        $repositorio = $this->getDoctrine()
                            ->getRepository('RHXMLReaderBundle:S2220indresult');

        $indresult = $repositorio->findOneBy(array('codigo' => $codigo));

        if($indresult == null){
            return new Response('CÓDIGO NÃO ENCONTRADO '.$codigo);
        }

        return new Response($indresult->getDescricao());
    }

    /**
     * Finds and displays a s2220indresult entity.
     *
     * @Route("/{id}", name="s2220indresult_show")
     * @Method("GET")
     */
    public function showAction(S2220indresult $s2220indresult)
    {
        $deleteForm = $this->createDeleteForm($s2220indresult);

        return $this->render('s2220indresult/show.html.twig', array(
            's2220indresult' => $s2220indresult,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing s2220indresult entity.
     *
     * @Route("/{id}/edit", name="s2220indresult_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220indresult $s2220indresult)
    {
        $deleteForm = $this->createDeleteForm($s2220indresult);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220indresultType', $s2220indresult);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220indresult_show', array('id' => $s2220indresult->getId()));
        }

        return $this->render('s2220indresult/edit.html.twig', array(
            's2220indresult' => $s2220indresult,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220indresult entity.
     *
     * @Route("/{id}", name="s2220indresult_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220indresult $s2220indresult)
    {
        $form = $this->createDeleteForm($s2220indresult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220indresult);
            $em->flush();
        }

        return $this->redirectToRoute('s2220indresult_index');
    }

    /**
     * Creates a form to delete a s2220indresult entity.
     *
     * @param S2220indresult $s2220indresult The s2220indresult entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220indresult $s2220indresult)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220indresult_delete', array('id' => $s2220indresult->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
