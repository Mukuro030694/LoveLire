<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Document\BookCover;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(
        EntityManagerInterface $entityManager,
        DocumentManager $dm,
        Security $security
    ): Response {
        $user = $security->getUser();

        if ($user instanceof AppUser) {
            $userId = (string) $user->getId();
            $books = $entityManager->getRepository(Book::class)->findBy(['userId' => $userId]);
        } else {
            $books = $entityManager->getRepository(Book::class)->createQueryBuilder('b')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        }

        $collection = $dm->getDocumentCollection(BookCover::class);

        //getting book IDs as strings
        $bookIds = array_map(fn(Book $book) => (string) $book->getId(), $books);

        $images = $collection
            ->find(['book_id' => ['$in' => $bookIds]])
            ->toArray();

        $imageMap = [];
        foreach ($images as $img) {
            $imageMap[(string) $img['book_id']] = $img['image_url'];
        }

        // Prepare books with string IDs for rendering
        $booksWithIdString = [];
        foreach ($books as $book) {
            $booksWithIdString[] = [
                'book' => $book,
                'idString' => (string) $book->getId(),
            ];
        }

        return $this->render('home.html.twig', [
            'books' => $booksWithIdString,
            'images' => $imageMap,
        ]);
    }
}
