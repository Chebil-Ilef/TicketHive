<?php

namespace App\Repository;

use App\Entity\Event;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        } 
    }
    /**
    * @return Event[] Returns an array of Event objects
    */
    public function findByDate (DateTime $today) : array 
    {
        $date = $today->format('Y-m-d');
        return $this->createQueryBuilder('e')
        ->andWhere('e.date = :dateJ')
        ->setParameter('dateJ' , $date)
        ->orderBy('e.nbplaces','Asc')
        ->setMaxResults(4)
        ->getQuery()
        ->getResult();
    }
    public function findByDateRange (DateTime $threeDaysAhead , Datetime $today) : array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date BETWEEN :start AND :end')
            ->setParameter('start', $today)
            ->setParameter('end', $threeDaysAhead)
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
    public function findByDateUpcoming (DateTime $weeks) : array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date >= :start')
            ->setParameter('start', $weeks)
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
    public function findByKeywords(String $keywords): array
    {
        $keyword = explode(" ",$keywords);
        $qb = $this->createQueryBuilder('e');

        $orExpr = $qb->expr()->orX();
        foreach ($keyword as $key => $value) {
            $orExpr->add($qb->expr()->like('e.name', ":keyword$key"));
            $orExpr->add($qb->expr()->like('e.description', ":keyword$key"));
            $qb->setParameter("keyword$key", '%' . $value . '%');
        }

        return $qb
            ->where($orExpr)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
