<?php

namespace App\Controller;

use App\Entity\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $collections  = $this->getDoctrine()->getRepository(Collection::class);
        $lastAdded    = $collections->findBy([], ['addedAt' => 'DESC'], 4);
        $addedByMonth = $this->countItemByMonth();

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData(
            [
                'labels'   => [
                    'Janvier',
                    'Février',
                    'Mars',
                    'Avril',
                    'Mai',
                    'Juin',
                    'Juillet',
                    'Août',
                    'Septembre',
                    'Octobre',
                    'Novembre',
                    'Décembre'
                ],
                'datasets' => [
                    [
                        'label'           => 'Nombre d\'ajouts par mois',
                        'data'            => array_values($addedByMonth), // nombre par mois
                        'backgroundColor' => [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        'borderColor'     => [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)'
                        ],
                        'borderWidth'     => 1
                    ]
                ]
            ]
        );

        return $this->render('home/index.html.twig', [
            'six_last' => $lastAdded,
            'chart'    => $chart
        ]);
    }

    private function countItemByMonth(): array
    {
        $collections = $this->getDoctrine()->getRepository(Collection::class)->findAll();
        $itemCountedByMonth = [];

        foreach($collections as $collection) {
            $itemCountedByMonth[] = $collection->getAddedAt()->format('m');
        }

        asort($itemCountedByMonth);

        return array_count_values($itemCountedByMonth);
    }
}
