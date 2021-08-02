<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Form\CollectionType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collection")
 */
class CollectionController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="collection")
     */
    public function index(): Response
    {
        $collections = $this->entityManager->getRepository(Collection::class)->findAll();

        return $this->render('collection/index.html.twig', [
            'collections' => $collections,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/add", name="collection_add")
     */
    public function add(Request $request): Response
    {
        $collection    = new Collection();
        $addCollection = $this->createForm(CollectionType::class, $collection);

        $addCollection->handleRequest($request);

        if ($addCollection->isSubmitted() && $addCollection->isValid()) {
            $collection = $addCollection->getData();
            $collection->setAddedAt(new \DateTimeImmutable());

            $this->entityManager->persist($collection);
            $this->entityManager->flush();

            $this->addFlash('success', 'Un nouvel objet a été ajouté');
            return $this->redirectToRoute('collection');
        }


        return $this->render('collection/add.html.twig', [
            'add_collection' => $addCollection->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/delete/{collection}", name="collection_delete", requirements={"collection"="\d+"})
     */
    public function delete(Collection $collection): Response
    {
        $this->entityManager->remove($collection);
        $this->entityManager->flush();

        return $this->redirectToRoute('collection');
    }
}
