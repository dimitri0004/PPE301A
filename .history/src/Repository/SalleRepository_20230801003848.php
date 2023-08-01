<?php

namespace App\Repository;

use App\Entity\Salle;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Salle>
 *
 * @method Salle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salle[]    findAll()
 * @method Salle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salle::class);
    }

    public function save(Salle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Salle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSallepaginated(int $page,  int $limit=4):array{
        $limit =abs($limit);
        $result= [];

        $query =$this->getEntityManager()->createQueryBuilder()
        ->select('e')
        ->from('APP\Entity\Salle','e')
        ->setMaxResults($limit)
        ->setFirstResult(($page*$limit)-$limit);
        $paginator =new Paginator($query);
        $data=$paginator->getQuery()->getResult();

        //verification de la diponibilite des donneee

        //if (empty($data)){

          //  return $result;
        //}

        //calcu du nombre de page

        $pages=ceil($paginator->count()/$limit);

        //on remplie le tableau 

        $result['data']=$data;
        $result['page']=$page;
        $result['pages']=$pages;
        $result['limit']=$limit;
      

    return $result;    

    }

//    /**
//     * @return Salle[] Returns an array of Salle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Salle
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
