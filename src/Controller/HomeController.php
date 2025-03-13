<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        $catsList = [
            ['id' => 1,'name' => 'Hector', 'description' => 'lorem ipsum', 'available' => true],
            ['id' => 2,'name' => 'Jasmin', 'description' => 'lorem ipsum', 'available' => false],
            ['id' => 3,'name' => 'Booba', 'description' => 'lorem ipsum', 'available' => true],
        ];

        $dogsList = [
            ['id' => 1,'name' => 'Rex', 'description' => 'lorem ipsum', 'available' => true],
            ['id' => 2,'name' => 'Buddy', 'description' => 'lorem ipsum', 'available' => false],
            ['id' => 3,'name' => 'Max', 'description' => 'lorem ipsum', 'available' => true],
        ];

        return $this->render('home/index.html.twig', [
            'cats_list' => $catsList,
            'dogs_list' => $dogsList,
        ]);
    }
}
