<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Util\Generator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(Generator $generator, EntityManagerInterface $entityManager)
    {
        /** @var User $user */
        $user = current($entityManager->getRepository(User::class)->findBy([], [], 1));

        return $this->render('default/index.html.twig', [
//            'cellar' => $generator->load($user->getCellar()),
        ]);
    }
}
