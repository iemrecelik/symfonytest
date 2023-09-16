<?php

namespace App\Repository;

use App\Entity\Book;
<<<<<<< HEAD
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
=======
use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
<<<<<<< HEAD
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
=======
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Book::class);
        $this->em = $em;
    }

    public function listWithLimit(Int $limit): array
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.bkName', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function addBook(Book $book): bool
    {
        $this->em->persist($book);
        $this->em->flush();

        return true;
    }

    public function updateBook(Book $book): bool
    {
        $this->em->persist($book);
        $this->em->flush();

        return true;
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
