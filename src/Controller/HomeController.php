<?php

// src/Controller/HomeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
    
        $comments = [
            [
                'bookCover' => 'images/books/cover1.jpg',
                'bookTitle' => 'Le Petit Prince',
                'author' => 'Jean Dupont',
                'text' => 'Un livre magnifique, très émouvant.',
                'rating' => 5,
            ],
            [
                'bookCover' => 'images/books/cover2.jpg',
                'bookTitle' => 'Les Misérables',
                'author' => 'Marie Curie',
                'text' => 'Une histoire bouleversante.',
                'rating' => 4,
            ],
            [
                'bookCover' => 'images/books/cover3.jpg',
                'bookTitle' => '1984',
                'author' => 'Pierre Martin',
                'text' => 'Une lecture captivante et inquiétante.',
                'rating' => 5,
            ],
        ];

        return $this->render('home.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return new Response('Page de login (stub)');
    }
}
