<?php

namespace App\Repository;

use App\Entity\Metier;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Metier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Metier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Metier[]    findAll()
 * @method Metier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Metier::class);
    }

    /**
     * @param array<string> $criteria
     *
     * @return Metier[]
     */
    public function findByCriteria(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('m');

        $filterByName = array_key_exists('name', $criteria);
        $filterById = array_key_exists('id', $criteria);

         if ($filterByName) {
            $name = $criteria['name'];

            $queryBuilder
                ->andWhere('m.name = :name')
                ->setParameter('name', $name);
        }
         if($filterById) {
            $id = $criteria['id'];

            $queryBuilder
                ->andWhere('m.id = :id')
                ->setParameter('id', $id);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
