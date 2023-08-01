<?php

namespace App\Repository;

use App\Entity\Directeur;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Directeur>
 *
 * @method Directeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Directeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Directeur[]    findAll()
 * @method Directeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirecteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Directeur::class);
    }

    public function save(Directeur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Directeur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findDirecteurpaginated(int $page,  int $limit=4):array{
        $limit =abs($limit);
        $result= [];

        $query =$this->getEntityManager()->createQueryBuilder()
        ->select('e')
        ->from('APP\Entity\Directeur','e')
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
//     * @return Directeur[] Returns an array of Directeur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Directeur
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
