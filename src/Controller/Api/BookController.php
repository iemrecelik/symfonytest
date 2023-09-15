<?php

namespace App\Controller\Api;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\BookCategory;
use App\Service\FileUploader;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use App\Repository\BookCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/book')]
class BookController extends AbstractController
{
    private $bookRepository;
    private $authorRepository;
    private $bookCategoryRepository;

    public function __construct(BookRepository $bookRepository, BookCategoryRepository $bookCategoryRepository, AuthorRepository $authorRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->bookCategoryRepository = $bookCategoryRepository;
    }

    #[Route('/', name: 'app_api_book_list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $page = $request->query->get('page') ?? 50;
        
        $books = $this->bookRepository->listWithLimit($page);

        foreach ($books as $book) {
            $datas[] = [
                'book_name' => $book->getBkName(),
            ];
        }

        return new JsonResponse($datas, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_api_book_show', methods:['GET'])]
    public function show($id): JsonResponse
    {
        $book= $this->bookRepository->find(['id' => $id]);

        if (empty($id)) {
            return new JsonResponse(['status' => 'Abone bulunamadı.'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $book->getId(),
            'book_name' => $book->getBkName(),
        ], Response::HTTP_CREATED);
    }

    #[Route(path: '/add', name: 'app_api_book_add', methods: ['POST'])]
    public function add(Request $request, FileUploader $fileUploader, ValidatorInterface $validator): JsonResponse
    {
        $params = $request->request->all();
        $imageFile = $request->files->get('imageFile');

        $bkName = $params['bkName'];
        $authorId = $params['authorId'];

        $author = $this->authorRepository->find(['id' => $authorId]);
        $book = new Book();
        $book->setBkName($bkName);
        $book->addAuthor($author);
        $book->setImageFile($imageFile);

        $errors = $validator->validate($book);

        if ($errors->count() > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }

            return new JsonResponse($messages);
        }else {
            $imageFileName = $fileUploader->upload($imageFile);
            $book->setImageFilename($imageFileName);
            $this->bookRepository->addBook($book);
        }

        return new JsonResponse(['status' => 'Abone ekleme işlemi başarılı.'], Response::HTTP_CREATED);
    }

    #[Route(path: '/{id}/update', name: 'app_api_book_update', methods: ['POST'])]
    public function update(Book $book, Request $request, FileUploader $fileUploader, ValidatorInterface $validator)
    {
        $params = $request->request->all();
        $imageFile = $request->files->get('imageFile');

        $authorIds = $params['authorId'];

        empty($params['bkName']) ? true : $book->setBkName($params['bkName']);
        empty($imageFile) ? true : $book->setImageFile($imageFile);
        
        // $authors = $this->authorRepository->findWithIds($authorIds);
        $authors = $this->authorRepository->findBy(['id' => $authorIds]);
        $authors = new \Doctrine\Common\Collections\ArrayCollection($authors);
        dd($book);
        $book->removeWithAuthors($authors);
        dd($book);
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $book->addAuthor($author);
            }
        }

        dd($book);

        $errors = $validator->validate($book);

        if ($errors->count() > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }

            return new JsonResponse($messages);
        }else {
            if (!empty($imageFile)) {
                $oldImageFileName = $book->getImageFilename();
                $fileUploader->remove($oldImageFileName);

                $imageFileName = $fileUploader->upload($imageFile);
                $book->setImageFilename($imageFileName);
            }
        }

        $this->bookRepository->updateBook($book);

        return new JsonResponse([
                'status' => "{$book->getId()} id'li {$book->getBkName()} isimli kitabın güncelleme işlemi başarılı."
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/add", name="add_subscriber", methods={"POST"})
     */
    /* public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $phone = $data['phone'];
        $cityId = $data['cityId'];

        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($cityId)) {
            return new JsonResponse(['status' => 'Zorunlu alanlar girilmelidir.'], Response::HTTP_NO_CONTENT);
        }

        $city = $this->cityRepository->findOneBy(['id' => $cityId]);
        $this->subscriberRepository->addSubscriber($firstName, $lastName, $email, $phone, $city);

        return new JsonResponse(['status' => 'Abone ekleme işlemi başarılı.'], Response::HTTP_CREATED);
    } */

    /**
     * @Route("/all", name="get_all_subscriber", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $subscribers = $this->subscriberRepository->findAll();
        $data = [];

        foreach ($subscribers as $subscriber) {
            $data[] = [
                'id' => $subscriber->getId(),
                'firstName' => $subscriber->getFirstName(),
                'lastName' => $subscriber->getLastName(),
                'email' => $subscriber->getEmail(),
                'phone' => $subscriber->getPhone(),
                'city' => $subscriber->getCity()->getName()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/update/{id}", name="update_subscriber", methods={"PUT"})
     */
    /* public function update($id, Request $request): JsonResponse
    {
        $subscriber = $this->subscriberRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['firstName']) ? true : $subscriber->setFirstName($data['firstName']);
        empty($data['lastName']) ? true : $subscriber->setLastName($data['lastName']);
        empty($data['email']) ? true : $subscriber->setEmail($data['email']);
        empty($data['phone']) ? true : $subscriber->setPhone($data['phone']);
        empty($data['cityId']) ? true : $subscriber->setCity($this->cityRepository->findOneBy(['id' => $data['cityId']]));

        $updatedSubscriber = $this->subscriberRepository->updateSubscriber($subscriber);

        return new JsonResponse($updatedSubscriber->toArray(), Response::HTTP_OK);
    } */

    /**
     * @Route("/delete/{id}", name="delete_subscriber", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $subscriber = $this->subscriberRepository->findOneBy(['id' => $id]);

        if (empty($subscriber)) {
            return new JsonResponse(['status' => 'Abone bulunamadı.'], Response::HTTP_NOT_FOUND);
        }

        $this->subscriberRepository->removeSubscriberr($subscriber);

        return new JsonResponse(['status' => 'Abone silindi.'], Response::HTTP_OK);
    }
}
