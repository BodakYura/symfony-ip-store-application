<?php

namespace bodakyuriy\IPStorageBundle\Controller;

use bodakyuriy\IPStorageBundle\Form\IPFormType;
use bodakyuriy\IPStorageBundle\Service\IPStorageService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IPStorageController
 * @package bodakyuriy\IPStorageBundle\Controller
 */
class IPStorageController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('@IPStorage/IPStorage/index.html.twig');
    }

    /**
     * @param Request $request
     * @param IPStorageService $IPStorageService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, IPStorageService $IPStorageService)
    {
        $result = null;
        $form = $this->createForm(IPFormType::class, null, [
            'action' => $this->generateUrl('ip_storage_add')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $IPStorageService->add($form->get('ip')->getData());
        }

        return $this->render('@IPStorage/IPStorage/form.twig', array(
            'form' => $form->createView(),
            'result' => $result
        ));
    }

    /**
     * @param Request $request
     * @param IPStorageService $IPStorageService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function queryAction(Request $request, IPStorageService $IPStorageService)
    {
        $result = null;
        $form = $this->createForm(IPFormType::class, null, [
            'action' => $this->generateUrl('ip_storage_query')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $IPStorageService->getCount($form->get('ip')->getData());
        }

        return $this->render('@IPStorage/IPStorage/form.twig', array(
            'form' => $form->createView(),
            'result' => $result
        ));
    }

}
