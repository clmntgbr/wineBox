<?php

namespace App\Controller;

use App\Entity\Wine\Appellation;
use App\Form\Wine\AppellationType;
use App\Util\Uploader;
use App\Util\WineData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Uploader */
    private $uploader;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var WineData */
    private $wineData;

    public function __construct(EntityManagerInterface $entityManager, Uploader $uploader, FormFactoryInterface $formFactory, WineData $wineData)
    {
        $this->entityManager = $entityManager;
        $this->uploader = $uploader;
        $this->formFactory = $formFactory;
        $this->wineData = $wineData;
    }

    /**
     * @Route("/ajax/wine_consumption_year", name="ajax_wine_consumption_year", methods={"GET"})
     */
    public function ajaxWineConsumptionYearAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response("This is not an AJAX request", 400);
        }

        $year = $request->query->get('year');

        if (is_null($year)) {
            return new JsonResponse(false);
        }

        return new JsonResponse($this->wineData->getWineConsumption($year));
    }

    /**
     * @Route("/ajax/wine_cellar_country", name="ajax_wine_cellar_country", methods={"GET"})
     */
    public function ajaxWineCellarCountryAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response("This is not an AJAX request", 400);
        }

        return new JsonResponse($this->wineData->getWineInCellarByCountry());
    }

    /**
     * @Route("/ajax/wine_appellation_create", name="ajax_wine_appellation_create", methods={"POST"})
     */
    public function ajaxWineAppellationCreateAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response("This is not an AJAX request", 400);
        }

        $entity = new Appellation();

        $form = $this->createForm(AppellationType::class, $entity, []);

        $form->handleRequest($request);

        if ($form->isValid() && $entity->hasUploadedFile()) {
            $entity->setPreview($this->uploader->upload($entity->getFile(), null, 'download/img', 'wine/appellation'));
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return new JsonResponse(true);
        }

        return new JsonResponse(false);
    }
}
