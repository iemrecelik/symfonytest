<?php

namespace App\Controller;

use App\Entity\BookCategory;
use App\Form\BookCategoryType;
use App\Repository\BookCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book/category')]
class BookCategoryController extends AbstractController
{
    #[Route('/', name: 'app_book_category_index', methods: ['GET'])]
    public function index(BookCategoryRepository $bookCategoryRepository): Response
    {
        return $this->render('book_category/index.html.twig', [
            'book_categories' => $bookCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookCategory = new BookCategory();
        $form = $this->createForm(BookCategoryType::class, $bookCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bookCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_category/new.html.twig', [
            'book_category' => $bookCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_category_show', methods: ['GET'])]
    public function show(BookCategory $bookCategory): Response
    {
        return $this->render('book_category/show.html.twig', [
            'book_category' => $bookCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookCategory $bookCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookCategoryType::class, $bookCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book_category/edit.html.twig', [
            'book_category' => $bookCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_category_delete', methods: ['POST'])]
    public function delete(Request $request, BookCategory $bookCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bookCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
