<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Entity\Wine\Appellation;
use App\Entity\Wine\Bottle;
use App\Entity\Wine\Box;
use App\Form\Wine\AppellationType;
use App\Util\Uploader;
use App\Util\WineData;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="ajax_")
 * @IsGranted("ROLE_USER", statusCode="403")
 */
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
     * @Route("/ajax/wine_consumption_year", name="wine_consumption_year", methods={"GET"})
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
     * @Route("/ajax/wine_box_country", name="wine_box_country", methods={"GET"})
     */
    public function ajaxWineBoxCountryAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response("This is not an AJAX request", 400);
        }

        return new JsonResponse($this->wineData->getWineInBoxByCountry());
    }

    /**
     * @Route("/ajax/wine_appellation_create", name="wine_appellation_create", methods={"POST"})
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

    /**
     * @Route("/ajax/wine_bottle_move", name="wine_bottle_move", methods={"POST"})
     */
    public function ajaxWineBottleMoveAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response("This is not an AJAX request", 400);
        }

        $id = $request->request->get('id') ?? null;
        $location = $request->request->get('location') ?? null;

        if (is_null($id)) {
            return new JsonResponse('missing parameter', 404);
        }

        /** @var User */
        $user = $this->getUser();

        $bottle = $this->entityManager->getRepository(Bottle::class)->findOneBy(['id' => $id]);

        if (!($bottle instanceof Bottle)) {
            return new JsonResponse('bottle not found', 404);
        }

        /** @var Box $box */
        $box = $user->getBox();

        if ($bottle->getBox()->getId() != $box->getId()) {
            return new JsonResponse('this is not your bottle', 404);
        }

        $bottle->setLocation($location);

        if (is_null($location)) {
            $location = 'empty';
            $bottle
                ->setEmptyAt(new \DateTime('now'))
                ->setStatus(Bottle::STATUS_EMPTY);
            $box
                ->addQuantity()
                ->addLiter($bottle->getWine()->getCapacity()->getValue()/100);
        }

        $this->entityManager->persist($bottle);
        $this->entityManager->persist($box);
        $this->entityManager->flush();

        return new JsonResponse(sprintf('everything worked [id:%s, location:%s]', $id, $location), 200);
    }
}
