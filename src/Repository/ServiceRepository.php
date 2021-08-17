<?php

namespace App\Repository;

use App\Entity\Metier;
use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

//    /**
//     * @param array<string> $criteria
//     *
//     * @return Service[]
//     */
//    public function findByCriteria(array $criteria): array
//    {
//        $queryBuilder = $this->createQueryBuilder('s');
//
//        $filterByName = array_key_exists('name', $criteria);
//        $filterById = array_key_exists('id', $criteria);
//
//        if ($filterByName) {
//            $name = $criteria['name'];
//
//            $queryBuilder
//                ->andWhere('m.name = :name')
//                ->setParameter('name', $name);
//        }
//        if($filterById) {
//            $id = $criteria['id'];
//
//            $queryBuilder
//                ->andWhere('m.id = :id')
//                ->setParameter('id', $id);
//        }
//
//        return $queryBuilder->getQuery()->getResult();
//    }
}
