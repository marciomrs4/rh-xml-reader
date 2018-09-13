<?php

namespace UserBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("admin/usuario")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_usuario_index")
     * @Method("GET")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="admin_usuario_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('UserBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $encoder = $this->get('security.encoder_factory')
                ->getEncoder($user);

            $user->setPassword($encoder->encodePassword($user->getPlainPassword(),
                $user->getSalt()));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_usuario_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_usuario_show")
     * @Method("GET")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="admin_usuario_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UserBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $encoder = $this->get('security.encoder_factory')
                ->getEncoder($user);

            $user->setPassword($encoder->encodePassword($user->getPlainPassword(),
                $user->getSalt()));

            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute('admin_usuario_show', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/myuser/{id}/edit", name="admin_my_usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editMyUserAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UserBundle\Form\UserType', $user);

        $editForm->remove('roles')
                 ->remove('isActive')
                 ->remove('username');

        $editForm->add('repetir_senha',PasswordType::class,array('mapped' => false));

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $userToken = $this->get('security.token_storage')->getToken()->getUser();


            if(($userToken == $user) and ($editForm->get('plainPassword')->getData() == $editForm->get('repetir_senha')->getData())) {

                $em = $this->getDoctrine()->getManager();

                $encoder = $this->get('security.encoder_factory')
                    ->getEncoder($user);

                $user->setPassword($encoder->encodePassword($user->getPlainPassword(),
                    $user->getSalt()));

                $em->persist($user);
                $em->flush();
            }else{

                $message = array('type' => 'warning', 'message' => 'Senha não foi alterada pois são diferentes.');
                $this->addFlash('notice',$message);

                return $this->render('user/edit.html.twig', array(
                    'user' => $user,
                    'edit_form' => $editForm->createView(),
                ));

            }

            $message = array('type' => 'success', 'message' => 'Senha alterada com sucess.');
            $this->addFlash('notice',$message);

            return $this->render('UserBundle:user:show_my_user.html.twig', array(
                'user' => $user
            ));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="admin_usuario_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_usuario_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_usuario_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
