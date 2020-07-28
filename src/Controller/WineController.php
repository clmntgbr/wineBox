<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Entity\Wine\Appellation;
use App\Entity\Wine\Bottle;
use App\Entity\Wine\Capacity;
use App\Entity\Wine\Cellar;
use App\Entity\Wine\Color;
use App\Entity\Wine\Domain;
use App\Entity\Wine\Region;
use App\Entity\Wine\Wine;
use App\Form\Wine\AppellationType;
use App\Form\Wine\BottleType;
use App\Form\Wine\CapacityType;
use App\Form\Wine\CellarType;
use App\Form\Wine\ColorType;
use App\Form\Wine\DomainType;
use App\Form\Wine\RegionType;
use App\Form\Wine\WineType;
use App\Util\Generator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WineController extends AbstractController
{
    /**
     * @Route("/appellation/create", name="appellation_create")
     */
    public function appellationCreateAction(Request $request, EntityManagerInterface $em, FormFactoryInterface $formFactory)
    {
        if ($request->isXmlHttpRequest()) {
            $appellation = new Appellation();

            $form = $formFactory->create(AppellationType::class, $appellation);
            $form->submit($request->request->get($form->getName()));
            dump($request);
            dump($form);
            dump($appellation);
            die;

            if ($form->isSubmitted() && $form->isValid()) {

                dump($appellation);
                die;
                $em->persist($appellation);
                $em->flush();
                return new JsonResponse(true);
            }
        }
        return new JsonResponse(false);
    }

    /**
     * @Route("/appellation/list", name="appellation_list")
     */
    public function appellationListAction(Request $request, EntityManagerInterface $em)
    {
        $appellations = $em->getRepository(Appellation::class)->findAll();

        dump($appellations);

        return $this->render('wine/appellation_list.html.twig', [
            'appellations' => $appellations
        ]);
    }

    /**
     * @Route("/bottle/create", name="bottle_create")
     */
    public function bottleCreateAction(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getBaseUser();

        $bottle = new Appellation();

        $form = $this->createForm(AppellationType::class, $bottle, []);

        return $this->render('wine/bottle_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    protected function getBaseUser(): ?User
    {
        if ($this->getUser() instanceof User) {
            return $this->getUser();
        }

        return null;
    }
}
