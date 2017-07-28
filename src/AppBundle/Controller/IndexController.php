<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User;
use FrontBundle\Form\SellerType;

class IndexController extends Controller
{
    /**
     * @Route("/mon-profil", name="application_homepage")
     */
    public function profileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
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


            $url= $this->generateUrl('application_homepage');
            $response = new RedirectResponse($url);
            return $response;
        }


        return $this->render('AppBundle:App:profile.html.twig', array(
            "user" => $user,
            'form' => $form->createView(),
        ));
    }
}
