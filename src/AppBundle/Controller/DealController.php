<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\User;
use AppBundle\Entity\Deal;
use AppBundle\Form\DealType;

/**
 * Deal controller.
 *
 * @Route("mes-bons-plans")
 */
class DealController extends Controller
{
    /**
     * @Route("/", name="application_deals")
     */
    public function profileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $deals = $em->getRepository('AppBundle:Deal')->findByCreatedBy($user->getId());

        return $this->render('AppBundle:Deal:list.html.twig', array(
            "deals" => $deals
        ));
    }

    /**
     * @Route("/nouveau", name="application_deal_new")
     */
    public function newAction(Request $request, $deal=false)
    {
        $deal = new Deal();

        $form   = $this->createCreateForm($deal);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Créer',
        ));

        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $deal->setCreatedBy($user);
            $deal->setEntite($user->getEntite());

            $str = '';
            $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

            for($i=0; $i < 5; $i++) {
                $str .= $pool[mt_rand(0, count($pool) - 1)];
            }
            $token = md5($str);
            $deal->setToken($token);
            $deal->setActive(false);

            $em->persist($deal);
            $em->flush();

            $url= $this->generateUrl('application_deal_fiche', array('id' => $deal->getToken()));
            $response = new RedirectResponse($url);
            return $response;
        }

        return $this->render('AppBundle:Deal:new.html.twig', array(
            'deal' => $deal,
            'form'   => $form->createView(),
        ));
    }

    /**
     * @Route("/creation", name="application_deal_create")
     */
    public function createAction(Request $request)
    {
        $deal = new Deal();
        $form = $this->createCreateForm($deal);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Créer',
        ));
        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $deal->setCreatedBy($user);
            $deal->setEntite($user->getEntite());

            $str = '';
            $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

            for($i=0; $i < 5; $i++) {
                $str .= $pool[mt_rand(0, count($pool) - 1)];
            }
            $token = md5($str);
            $deal->setToken($token);
            $deal->setActive(false);

            $em->persist($deal);
            $em->flush();

            $url= $this->generateUrl('application_deal_fiche', array('id' => $deal->getToken()));
            $response = new RedirectResponse($url);
            return $response;
        }

        return $this->render('AppBundle:Deal:new.html.twig', array(
            'deal' => $deal,
            'form'   => $form->createView(),
        ));
    }

    private function createCreateForm(Deal $deal)
    {
        $form = $this->createForm(DealType::class, $deal);

        return $form;
    }
    /**
     * @Route("/fiche/{id}", name="application_deal_fiche")
     */
    public function ficheAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $deal = $em->getRepository('AppBundle:Deal')->findOneByToken($id);

        $deleteForm = $this->createDeleteForm($deal);

        return $this->render('AppBundle:Deal:fiche.html.twig', array(
            'deal' => $deal,
            'deleteForm' => $deleteForm->createView(),
        ));
    }
    /**
     * Finds and displays a category entity.
     *
     * @Route("/modification/{id}", name="application_deal_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deal = $em->getRepository('AppBundle:Deal')->findOneByToken($id);

        $form = $this->createForm('AppBundle\Form\DealType', $deal);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Modifier',
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('application_deal_fiche', array('id' => $deal->getToken()));
        }

        return $this->render('AppBundle:Deal:edit.html.twig', array(
            'deal' => $deal,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/ajax/active", name="application_deal_active")
     */
    public function activeDealAction(Request $request)
    {
        $d = $request->request->get('deal');
        $em = $this->getDoctrine()->getManager();

        $success = false;

        $deal = $em->getRepository('AppBundle:Deal')->findOneByToken($d);
        if($deal) {
            $date = new \DateTime();
            $duration = '+'.$deal->getDuration().' months';


            $deal->setBeginAt($date);
            $em->persist($deal);
            $em->flush();
            $endDate = $date;
            $endDate->modify($duration);
            $deal->setEndAt($endDate);

            $deal->setActive(true);
            $em->persist($deal);
            $em->flush();
            $success = true;
        }

        return new JsonResponse(array('success' => $success));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="application_deal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Deal $deal)
    {
        $form = $this->createDeleteForm($deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($deal);
            $em->flush();
        }

        return $this->redirectToRoute('application_category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Deal $deal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('application_deal_delete', array('id' => $deal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
