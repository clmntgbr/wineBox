<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\User\User;
use App\Entity\Wine\Appellation;
use App\Entity\Wine\Capacity;
use App\Entity\Wine\Color;
use App\Entity\Wine\Domain;
use App\Entity\Wine\Region;
use App\Entity\Wine\Wine;
use App\Form\Wine\AppellationType;
use App\Form\Wine\DomainType;
use App\Form\Wine\RegionType;
use App\Form\Wine\WineType;
use App\Util\BoxGenerator;
use App\Util\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="wine_")
 * @IsGranted("ROLE_USER", statusCode="403")
 */
class WineController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Uploader */
    private $uploader;

    /** @var BoxGenerator */
    private $generator;

    public function __construct(EntityManagerInterface $entityManager, Uploader $uploader, BoxGenerator $generator)
    {
        $this->entityManager = $entityManager;
        $this->uploader = $uploader;
        $this->generator = $generator;
    }

    //region WineAppellation

    /**
     * @Route("appellation/create", name="appellation_create")
     */
    public function wineAppellationCreateAction(Request $request)
    {
        $entity = new Appellation();

        $form = $this->createForm(AppellationType::class, $entity, []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $entity->hasUploadedFile()) {
            $entity->setPreview($this->uploader->upload($entity->getFile(), null, Media::TYPE, Media::DIRECTORY_APPELLATION));
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return $this->redirectToRoute('wine_appellation_show', ['slug' => $entity->getSlug()], 302);
        }

        return $this->render('wine/appellation_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("appellation/{slug}/show", name="appellation_show")
     * @ParamConverter("entity", class="App\Entity\Wine\Appellation", options={"mapping": {"slug": "slug"}})
     */
    public function wineAppellationShowAction(Request $request, Appellation $entity)
    {
        return $this->render('wine/appellation_show.html.twig', [
            'entity' => $entity
        ]);
    }

    //endregion

    //region WineDomain

    /**
     * @Route("domain/create", name="domain_create")
     */
    public function wineDomainCreateAction(Request $request)
    {
        $entity = new Domain();

        $form = $this->createForm(DomainType::class, $entity, []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $entity->hasUploadedFile()) {
            $entity->setPreview($this->uploader->upload($entity->getFile(), null, Media::TYPE, Media::DIRECTORY_DOMAIN));
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return $this->redirectToRoute('wine_domain_show', ['slug' => $entity->getSlug()], 302);
        }

        return $this->render('wine/domain_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("domain/{slug}/show", name="domain_show")
     * @ParamConverter("entity", class="App\Entity\Wine\Domain", options={"mapping": {"slug": "slug"}})
     */
    public function wineDomainShowAction(Request $request, Domain $entity)
    {
        return $this->render('wine/domain_show.html.twig', [
            'entity' => $entity
        ]);
    }

    //endregion

    //region WineRegion

    /**
     * @Route("region/create", name="region_create")
     */
    public function wineRegionCreateAction(Request $request)
    {
        $entity = new Region();

        $form = $this->createForm(RegionType::class, $entity, []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $entity->hasUploadedFile()) {
            $entity->setPreview($this->uploader->upload($entity->getFile(), null, Media::TYPE, Media::DIRECTORY_REGION));
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return $this->redirectToRoute('wine_region_show', ['slug' => $entity->getSlug()], 302);
        }

        return $this->render('wine/region_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("region/{slug}/show", name="region_show")
     * @ParamConverter("entity", class="App\Entity\Wine\Region", options={"mapping": {"slug": "slug"}})
     */
    public function wineRegionShowAction(Request $request, Region $entity)
    {
        return $this->render('wine/region_show.html.twig', [
            'entity' => $entity
        ]);
    }

    //endregion

    //region Wine

    /**
     * @Route("wine/create", name="wine_create")
     */
    public function wineWineCreateAction(Request $request)
    {
        $entity = new Wine();

        $form = $this->createForm(WineType::class, $entity, []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $entity->hasUploadedFile()) {
            $entity->setPreview($this->uploader->upload($entity->getFile(), null, Media::TYPE, Media::DIRECTORY_WINE));
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return $this->redirectToRoute('wine_wine_show', ['slug' => $entity->getSlug()], 302);
        }

        return $this->render('wine/wine_create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("wine/{slug}/show", name="wine_show")
     * @ParamConverter("entity", class="App\Entity\Wine\Wine", options={"mapping": {"slug": "slug"}})
     */
    public function wineWineShowAction(Request $request, Wine $entity)
    {
        return $this->render('wine/wine_show.html.twig', [
            'entity' => $entity
        ]);
    }

    //endregion

    //region WineCapacity

    /**
     * @Route("capacity/{slug}/show", name="capacity_show")
     * @ParamConverter("entity", class="App\Entity\Wine\Capacity", options={"mapping": {"slug": "slug"}})
     */
    public function wineCapacityShowAction(Request $request, Capacity $entity)
    {
        return $this->render('wine/capacity_show.html.twig', [
            'entity' => $entity
        ]);
    }

    //endregion

    //region WineColor

    /**
     * @Route("color/{slug}/show", name="color_show")
     * @ParamConverter("entity", class="App\Entity\Wine\Color", options={"mapping": {"slug": "slug"}})
     */
    public function wineColorShowAction(Request $request, Color $entity)
    {
        return $this->render('wine/color_show.html.twig', [
            'entity' => $entity
        ]);
    }

    //endregion

    //region WineBox

    /**
     * @Route("box/show", name="box_show")
     */
    public function wineBoxShowAction(Request $request)
    {
        /** @var User */
        $user = $this->getUser();

        $bid = $request->query->get('bid') ?? 0;

        return $this->render('wine/box_show.html.twig', [
            'box' => $this->generator
                ->setIds([$bid])
                ->setAddBottles(true)
                ->load($user->getBox()),
            'bid' => $bid,
        ]);
    }

    //endregion
}
