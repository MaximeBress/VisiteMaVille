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

class DealController extends Controller
{
    /**
     * @Route("/bons-plans/{category}/{town}", name="front_search")
     */
    public function listAction($category, $town)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->findOneByCode($category);
        $town = $em->getRepository('AppBundle:Town')->findOneByCode($town);

        $deals = $em->getRepository('AppBundle:Deal')->findByCriteres($category->getId(), $town->getId());

        return $this->render('FrontBundle:Deal:list.html.twig', array(
            'deals' => $deals,
            'category' => $category,
            'town' => $town,
        ));
    }
    /**
     * @Route("/bon-plan/{entite}", name="front_enterprise")
     */
    public function showAction($entite)
    {
        $em = $this->getDoctrine()->getManager();
        $entite = $em->getRepository('AppBundle:Enterprise')->find($entite);
        $deals = $em->getRepository('AppBundle:Deal')->findBy(array(
            'entite' => $entite->getId(), 'active' => true
        ));

        return $this->render('FrontBundle:Deal:show.html.twig', array(
            'entite' => $entite,
            'deals' => $deals
        ));
    }

}
