<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;
use AppBundle\Entity\Enterprise;
use FrontBundle\Form\CustomerType;
use FrontBundle\Form\SellerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class IndexController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function indexAction(Request $request)
    {
        $user = new User();
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
            $session->getFlashBag()->add('inscription', 'Votre inscription a bien été prise en compte');

            $url= $this->generateUrl('front_homepage');
            $response = new RedirectResponse($url);
            return $response;
        }
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $towns = $em->getRepository('AppBundle:Town')->findAll();

        return $this->render('FrontBundle:Front:index.html.twig', array(
            'form' => $form->createView(),
            'categories' => $categories,
            'towns' => $towns
        ));
    }
    /**
     * @Route("/search-form", name="search_form")
     */
    public function searchFormAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $towns = $em->getRepository('AppBundle:Town')->findAll();

        return $this->render('FrontBundle:Front:searchform.html.twig', array(
            'categories' => $categories,
            'towns' => $towns
        ));
    }

    /**
     * @Route("/inscription-commercant", name="register_seller")
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
            $enterprise->setLatitude($form->get('entite')->get('latitude')->getData());
            $enterprise->setLongitude($form->get('entite')->get('longitude')->getData());
            $em->persist($enterprise);
            $em->flush();
            $user->addRole('ROLE_SELLER');
            $user->setUsername($username);
            $user->setEnabled(true);
            $user->setEntite($enterprise);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $session = new Session();
            $session->getFlashBag()->add('inscription', 'Votre inscription a bien été prise en compte');


            $url= $this->generateUrl('front_homepage');
            $response = new RedirectResponse($url);
            return $response;
        }
        return $this->render('FrontBundle:Front:register-seller.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/inscription-utilisateur", name="register_user")
     */
    public function registerUserAction(Request $request)
    {
        $user = new User();
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
            $session->getFlashBag()->add('inscription', 'Votre inscription a bien été prise en compte');

            $url= $this->generateUrl('front_homepage');
            $response = new RedirectResponse($url);
            return $response;
        }
        return $this->render('FrontBundle:Front:register-user.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
