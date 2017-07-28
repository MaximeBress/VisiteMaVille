<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User;
use AppBundle\Entity\Enterprise;
use FrontBundle\Form\CustomerType;
use FrontBundle\Form\SellerType;


class UserController extends Controller
{
    /**
     * @Route("/utilisateurs", name="application_users_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $customers = $em->getRepository('UserBundle:User')->findByRole('ROLE_CUSTOMER');
        $sellers = $em->getRepository('UserBundle:User')->findByRole('ROLE_SELLER');

        return $this->render('AppBundle:User:list.html.twig', array(
            "customers" => $customers,
            "sellers" => $sellers
        ));
    }
    /**
     * @Route("/utilisateurs/creation-commercant", name="create_seller")
     */
    public function registerSellerAction(Request $request)
    {
        $user = new User();
        $enterprise = new Enterprise();
        $form = $this->createForm(SellerType::class, $user);
        $form->add('creer', SubmitType::class);

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('email')->getData();
            $enterprise->setName($form->get('entite')->get('name')->getData());
            $enterprise->setTelephone($form->get('entite')->get('telephone')->getData());
            $enterprise->setStreet($form->get('entite')->get('street')->getData());
            $enterprise->setCp($form->get('entite')->get('cp')->getData());
            $enterprise->setTown($form->get('entite')->get('town')->getData());
            $em->persist($enterprise);
            $em->flush();
            $user->addRole('ROLE_SELLER');
            $user->setUsername($username);
            $user->setEnabled(true);
            $user->setEntite($enterprise);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $session = new Session();
            $session->getFlashBag()->add('inscription-seller', 'Votre création a bien été prise en compte');


            $url= $this->generateUrl('application_users_list');
            $response = new RedirectResponse($url);
            return $response;
        }
        return $this->render('AppBundle:User:create-seller.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/utilisateurs/creation-client", name="create_customer")
     */
    public function registerCustomerAction(Request $request)
    {
        $user = new User();
        $enterprise = new Enterprise();
        $form = $this->createForm(CustomerType::class, $user);
        $form->add('creer', SubmitType::class);

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('email')->getData();
            $user->addRole('ROLE_CUSTOMER');
            $user->setUsername($username);
            $user->setEnabled(true);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $session = new Session();
            $session->getFlashBag()->add('inscription-customer', 'Votre création a bien été prise en compte');

            $url= $this->generateUrl('application_users_list');
            $response = new RedirectResponse($url);
            return $response;
        }
        return $this->render('AppBundle:User:create-customer.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/utilisateurs/profile/{id}", name="application_user_profile_customer")
     */
    public function profileCustomerAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        $form = $this->createForm(CustomerType::class, $user);
        $form->add('modifier', SubmitType::class);

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $session = new Session();
            $session->getFlashBag()->add('modification', 'Vos modifications ont bien été prise en compte');

            $url= $this->generateUrl('application_user_profile_customer', array('id' => $user->getId()));
            $response = new RedirectResponse($url);
            return $response;
        }
        $deleteForm = $this->createDeleteCustomerForm($user);
        $deleteForm->add('supprimer', SubmitType::class);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em->remove($user);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('suppression', "L'utilisateur a bien été supprimé");
            return $this->redirectToRoute('application_users_list');
        }

        return $this->render('AppBundle:User:profile-customer.html.twig', array(
            "user" => $user,
            'form' => $form->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }
    /**
     * @Route("/utilisateurs/profile-seller/{id}", name="application_user_profile_seller")
     */
    public function profileSellerAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        $enterprise = $user->getEntite();

        $form = $this->createForm(SellerType::class, $user);
        $form->add('modifier', SubmitType::class);

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enterprise->setName($form->get('entite')->get('name')->getData());
            $enterprise->setTelephone($form->get('entite')->get('telephone')->getData());
            $enterprise->setStreet($form->get('entite')->get('street')->getData());
            $enterprise->setCp($form->get('entite')->get('cp')->getData());
            $enterprise->setTown($form->get('entite')->get('town')->getData());
            $em->persist($enterprise);
            $em->flush();
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $session = new Session();
            $session->getFlashBag()->add('modification', 'Vos modifications ont bien été prise en compte');


            $url= $this->generateUrl('application_user_profile_seller', array('id' => $user->getId()));
            $response = new RedirectResponse($url);
            return $response;
        }

        $deleteForm = $this->createDeleteSellerForm($user);
        $deleteForm->add('supprimer', SubmitType::class);

        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em->remove($user);
            $em->flush();
            $session = new Session();
            $session->getFlashBag()->add('suppression', "L'utilisateur a bien été supprimé");
            return $this->redirectToRoute('application_users_list');
        }

        return $this->render('AppBundle:User:profile-seller.html.twig', array(
            "user" => $user,
            'form' => $form->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    private function createDeleteSellerForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('application_user_profile_seller', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    private function createDeleteCustomerForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('application_user_profile_customer', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
