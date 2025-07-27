<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/user')]
class UserController extends AbstractController
{
    #[Route('/delete/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteAccount(Uuid $id): JsonResponse
    {
        // Только админ может удалять аккаунты
    }
}
