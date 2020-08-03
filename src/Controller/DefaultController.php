<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Util\WineData;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var WineData */
    private $wineData;

    public function __construct(EntityManagerInterface $entityManager, WineData $wineData)
    {
        $this->entityManager = $entityManager;
        $this->wineData = $wineData;
    }

    /**
     * @Route("/", name="homepage")
     * @IsGranted("ROLE_USER", statusCode="403")
     */
    public function homepageAction(EntityManagerInterface $entityManager)
    {
        /** @var User */
        $user = $this->getUser();

        return $this->render('default/homepage.html.twig', [
            'getWineColorsInCellar' => $this->wineData->getWineColorsInCellar(),
            'getWineConsumptionYears' => $this->wineData->getWineConsumptionYears(),
            'getWineBottlesInCellarCount' => $this->wineData->getWineBottlesInCellarCount(),
            'getWineCellarPercent' => $this->wineData->getWineCellarPercent(),
            'wineConsumptionInLiter' => $user->getCellar()->getLiter(),
            'getWineCellarLeftPlaces' => $this->wineData->getWineCellarLeftPlaces(),
            'getWineBottleApogee' => $this->wineData->getWineBottleApogee(),
            'getWineBottleAlert' => $this->wineData->getWineBottleAlert(),
        ]);
    }
}
