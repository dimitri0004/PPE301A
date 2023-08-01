<?php

namespace App\Repository;

use App\Entity\EmploiTemps;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<EmploiTemps>
 *
 * @method EmploiTemps|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmploiTemps|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmploiTemps[]    findAll()
 * @method EmploiTemps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmploiTempsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmploiTemps::class);
    }

    public function save(EmploiTemps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmploiTemps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findEmploipaginated(int $page,  int $limit=4):array{
        $limit =abs($limit);
        $result= [];

        $query =$this->getEntityManager()->createQueryBuilder()
        ->select('e')
        ->from('APP\Entity\EmploiTemps','e')
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
//     * @return EmploiTemps[] Returns an array of EmploiTemps objects
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

//    public function findOneBySomeField($value): ?EmploiTemps
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
