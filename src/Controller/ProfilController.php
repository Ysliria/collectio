<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Entity\UserCollection;
use App\Form\UserCollectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="profil")
     */
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    /**
     * @Route("/add_collection/{collection}", name="add_collection")
     */
    public function addCollection(Collection $collection, Request $request): Response
    {
        $userCollection = new UserCollection();
        $addCollectionToUserForm = $this->createForm(UserCollectionType::class, $userCollection);

        $addCollectionToUserForm->handleRequest($request);

        if ($addCollectionToUserForm->isSubmitted() && $addCollectionToUserForm->isValid()) {
            $userCollection = $addCollectionToUserForm->getData();

            $userCollection->setCollection($collection);
            $userCollection->setUser($this->getUser());
            $userCollection->setFavourite($userCollection->getFavourite() ?? false);

            $this->entityManager->persist($userCollection);
            $this->entityManager->flush();

            $this->addFlash('success', $userCollection->getCollection()->getName() . ' a été ajouté à votre collection !');
            
            return $this->redirectToRoute('profil');
        }

        return $this->render('profil/addCollection.html.twig', [
            'collection' => $collection,
            'add_collection' => $addCollectionToUserForm->createView()
        ]);
    }
}
