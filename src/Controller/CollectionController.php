<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Form\CollectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('collection/index.html.twig', [
            'controller_name' => 'CollectionController',
        ]);
    }

    /**
     * @Route("/add", name="collection_add")
     */
    public function add(): Response
    {
        $collection = new Collection();
        $addCollection = $this->createForm(CollectionType::class, $collection);

        return $this->render('collection/add.html.twig', [
            'add_collection' => $addCollection->createView()
        ]);
    }
}
