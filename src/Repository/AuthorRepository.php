<?php

namespace App\Repository;

use App\Entity\Author;
<<<<<<< HEAD
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
=======
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
<<<<<<< HEAD
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
=======
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Author::class);
        $this->em = $em;
    }

    public function findWithIds(Array $authorId)
    {
        return $this->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $authorId)
            ->getQuery()
            ->getResult()
        ;
>>>>>>> 50ec0615f45b65cf1eb4b58f6530eee7522c93a5
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
