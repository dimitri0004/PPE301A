<?php

namespace App\Repository;

use App\Entity\Proffesseur;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Proffesseur>
 *
 * @method Proffesseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proffesseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proffesseur[]    findAll()
 * @method Proffesseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProffesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proffesseur::class);
    }

    public function save(Proffesseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Proffesseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findProffesseurpaginated(int $page,  int $limit=4):array{
        $limit =abs($limit);
        $result= [];

        $query =$this->getEntityManager()->createQueryBuilder()
        ->select('e')
        ->from('APP\Entity\Proffesseur','e')
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
//     * @return Proffesseur[] Returns an array of Proffesseur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Proffesseur
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
