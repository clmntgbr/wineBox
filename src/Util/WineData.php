<?php

namespace App\Util;

use App\Entity\Country;
use App\Entity\User\User;
use App\Entity\Wine\Bottle;
use App\Entity\Wine\Color;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WineData
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function getWineColors()
    {
        return $this->entityManager->getRepository(Color::class)->findAll();
    }

    public function getWineColorsInBox()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $box = $user->getBox();

        $data = [];
        foreach ($this->getWineColors() as $wineColor) {
            $data[$wineColor->getSlug()] = ['count' => 0, 'entity' => $wineColor];
        }

        $bottles = $this->entityManager->getRepository(Bottle::class)->getWineBottlesInBox($user->getBox());

        foreach ($bottles as $bottle) {
            $data[$bottle['color_slug']]['count']++;
        }

        return $data;
    }

    public function getWineConsumption(string $year)
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        if(is_null($year)) {
            $year = (new \DateTime('now'))->format('Y');
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->entityManager->getRepository(Bottle::class)->getWineConsumption($user->getBox(), $year);
    }

    public function getWineConsumptionYears()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->entityManager->getRepository(Bottle::class)->getWineConsumptionYears($user->getBox());
    }

    public function getWineInBoxByCountry()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Country[] $countries */
        $countries = $this->entityManager->getRepository(Country::class)->findAll();

        $datas = $this->entityManager->getRepository(Bottle::class)->getWineInBoxByCountry($user->getBox());

        foreach ($countries as $country) {
            if (false === array_search($country->getIso3(), array_column($datas, 'code'))) {
                $datas[] = ['code' => $country->getIso3(), 'value' => 0, 'name' => $country->getName()];
            }
        }

        return $datas;
    }

    public function getWineBottlesInBoxCount()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $datas = $this->entityManager->getRepository(Bottle::class)->getWineBottlesInBox($user->getBox());

        return count($datas);
    }

    public function getWineBottlesInBox()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->entityManager->getRepository(Bottle::class)->getWineBottlesInBox($user->getBox());
    }

    public function getWineBoxPercent()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $percent = round(($this->getWineBottlesInBoxCount()/($user->getBox()->getHorizontal() * $user->getBox()->getVertical()))*100);

        if ($percent <= 70) {
            return [
                'percent' => $percent,
                'color' => '#2ecc71',
            ];
        }

        if ($percent > 90) {
            return [
                'percent' => $percent,
                'color' => '#e74c3c',
            ];
        }

        return [
            'percent' => $percent,
            'color' => '#f39c12',
        ];
    }

    public function getWineBoxLeftPlaces()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $leftPlaces = ($user->getBox()->getHorizontal() * $user->getBox()->getVertical()) - $this->getWineBottlesInBoxCount();

        if ($leftPlaces <= 10) {
            return [
                'left_places' => $leftPlaces,
                'color' => '#e74c3c',
            ];
        }

        if ($leftPlaces >= 20) {
            return [
                'left_places' => $leftPlaces,
                'color' => '#2ecc71',
            ];
        }

        return [
            'left_places' => $leftPlaces,
            'color' => '#f39c12',
        ];
    }

    public function getWineBottleApogee()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->entityManager->getRepository(Bottle::class)->getWineBottleApogee($user->getBox());
    }

    public function getWineBottleAlert()
    {
        if (is_null($this->tokenStorage->getToken())) {
            return null;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        return $this->entityManager->getRepository(Bottle::class)->getWineBottleAlert($user->getBox());
    }
}