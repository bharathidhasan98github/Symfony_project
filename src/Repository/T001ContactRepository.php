<?php

namespace App\Repository;

use App\Entity\T001Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<T001Contact>
 *
 * @method T001Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method T001Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method T001Contact[]    findAll()
 * @method T001Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class T001ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, T001Contact::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(T001Contact $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(T001Contact $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getContactDetails($em){
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = :val')
            ->setParameter('val', 0)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return T001Contact[] Returns an array of T001Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?T001Contact
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
