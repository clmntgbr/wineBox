<?php

namespace App\Controller;

use App\Util\Gas;
use App\Util\WineData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax/wine_consumption_year", name="ajax_wine_consumption_year", methods={"GET"})
     */
    public function ajaxWineConsumptionYearAction(Request $request, WineData $wineData)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response("This is not an AJAX request", 400);
        }

        $year = $request->query->get('year');

        if (is_null($year)) {
            return new JsonResponse(false);
        }

        return new JsonResponse($wineData->getWineConsumption($year));
    }

    /**
     * @Route("/ajax/wine_cellar_country", name="ajax_wine_cellar_country", methods={"GET"})
     */
    public function ajaxWineCellarCountryAction(Request $request, WineData $wineData)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response("This is not an AJAX request", 400);
        }

        return new JsonResponse($wineData->getWineInCellarByCountry());
    }
}
