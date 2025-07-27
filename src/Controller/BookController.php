<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use App\Entity\AppUser;


#[Route('/book')]
final class BookController extends AbstractController
{

    #[Route('/add', name: 'book_add', methods: ['POST'])]
    public function addBook(
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (empty($data['title'])) {
            return new JsonResponse(['error' => 'Title is required'], Response::HTTP_BAD_REQUEST);
        }

        /** @var AppUser|null $user */
        $user = $security->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setNote($data['note'] ?? null);
        $book->setStatus($data['status'] ?? null);
        $book->setComment($data['comment'] ?? null);
        $book->setUserId($user->getId());

        $entityManager->persist($book);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Book added successfully',
            'bookId' => $book->getId()
        ], Response::HTTP_CREATED);
    }



    #[Route('/delete/{id}', name: 'book_delete', methods: ['DELETE'])]
    public function deleteBook(Uuid $id): JsonResponse
    {
        // Удаляет книгу, если пользователь — владелец или админ
    }

    #[Route('/modify/{id}', name: 'book_modify', methods: ['PUT'])]
    public function modifyBook(Uuid $id, Request $request): JsonResponse
    {
        // Изменяет книгу (название, комментарий, статус и т.д.)
    }

    #[Route('/status/{id}', name: 'book_change_status', methods: ['PATCH'])]
    public function changeBookStatus(Uuid $id, Request $request): JsonResponse
    {
        // Обновляет статус (à lire, en cours, terminé)
    }

    #[Route('/rate/{id}', name: 'book_rate', methods: ['PATCH'])]
    public function rateBook(Uuid $id, Request $request): JsonResponse
    {
        // Устанавливает или обновляет рейтинг (0–5)
    }

    #[Route('/filter', name: 'book_filter', methods: ['GET'])]
    public function filterBooks(Request $request): JsonResponse
    {
        // Фильтрация по статусу, оценке и т.п.
    }
}
