<?php

namespace App\Controller;

use App\Entity\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $collections = $this->getDoctrine()->getRepository(Collection::class);
        $sixLast = $collections->findBy([], ['addedAt' => 'DESC'], 2);

        return $this->render('home/index.html.twig', [
            'six_last' => $sixLast,
        ]);
    }
}
