<?php

namespace RH\XMLReaderBundle\Controller;

use RH\XMLReaderBundle\Entity\S2220ordexame;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * S2220ordexame controller.
 *
 * @Route("s2220ordexame")
 */
class S2220ordexameController extends Controller
{
    /**
     * Lists all s2220ordexame entities.
     *
     * @Route("/", name="s2220ordexame_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $s2220ordexames = $em->getRepository('RHXMLReaderBundle:S2220ordexame')->findAll();

        return $this->render('s2220ordexame/index.html.twig', array(
            's2220ordexames' => $s2220ordexames,
        ));
    }

    /**
     * Creates a new s2220ordexame entity.
     *
     * @Route("/new", name="s2220ordexame_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $s2220ordexame = new S2220ordexame();
        $form = $this->createForm('RH\XMLReaderBundle\Form\S2220ordexameType', $s2220ordexame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s2220ordexame);
            $em->flush();

            return $this->redirectToRoute('s2220ordexame_show', array('id' => $s2220ordexame->getId()));
        }

        return $this->render('s2220ordexame/new.html.twig', array(
            's2220ordexame' => $s2220ordexame,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a s2220ordexame entity.
     *
     * @Route("/{id}", name="s2220ordexame_show")
     * @Method("GET")
     */
    public function showAction(S2220ordexame $s2220ordexame)
    {
        $deleteForm = $this->createDeleteForm($s2220ordexame);

        return $this->render('s2220ordexame/show.html.twig', array(
            's2220ordexame' => $s2220ordexame,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     * @Route("/codigo/{codigo}", name="s2220ordexame_codigo_show")
     * @Method("GET")
     */
    public function findDescricaoByCodigoshowAction($codigo=null)
    {
        $repositorio = $this->getDoctrine()
                            ->getRepository('RHXMLReaderBundle:S2220ordexame');

        $ordexame = $repositorio->findOneBy(array('codigo' => $codigo));

        if($ordexame == null){
            return new Response('CÓDIGO NÃO ENCONTRADO '.$codigo);
        }

        return new Response($ordexame->getDescricao());
    }


    /**
     * Displays a form to edit an existing s2220ordexame entity.
     *
     * @Route("/{id}/edit", name="s2220ordexame_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, S2220ordexame $s2220ordexame)
    {
        $deleteForm = $this->createDeleteForm($s2220ordexame);
        $editForm = $this->createForm('RH\XMLReaderBundle\Form\S2220ordexameType', $s2220ordexame);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('s2220ordexame_show', array('id' => $s2220ordexame->getId()));
        }

        return $this->render('s2220ordexame/edit.html.twig', array(
            's2220ordexame' => $s2220ordexame,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a s2220ordexame entity.
     *
     * @Route("/{id}", name="s2220ordexame_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, S2220ordexame $s2220ordexame)
    {
        $form = $this->createDeleteForm($s2220ordexame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($s2220ordexame);
            $em->flush();
        }

        return $this->redirectToRoute('s2220ordexame_index');
    }

    /**
     * Creates a form to delete a s2220ordexame entity.
     *
     * @param S2220ordexame $s2220ordexame The s2220ordexame entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(S2220ordexame $s2220ordexame)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('s2220ordexame_delete', array('id' => $s2220ordexame->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
