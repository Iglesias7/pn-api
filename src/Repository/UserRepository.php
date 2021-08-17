<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    /**
     * @ORM\Column(type="string")
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        parent::__construct($registry, User::class);
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param array<string> $criteria
     *
     * @return User[]
     */
    public function findByCriteria(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('u');

        $filterByEmail = array_key_exists('email', $criteria);
        $filterByPseudo = array_key_exists('pseudo', $criteria);
        $filterByPassword = array_key_exists('password', $criteria);
        $filterById = array_key_exists('id', $criteria);

        if ($filterByEmail && $filterByPassword) {
            $email = $criteria['email'];
            $user = $this->findOneBy(['email' => $criteria['email']]);

            if($this->userPasswordEncoder->isPasswordValid($user, $criteria['password'])) {
                $queryBuilder
                    ->andWhere('u.email = :email')
                    ->setParameter('email', $email);
            } else {
                return [];
            }
        } else if ($filterByPseudo) {
            $pseudo = $criteria['pseudo'];

            $queryBuilder
                ->andWhere('u.pseudo = :pseudo')
                ->setParameter('pseudo', $pseudo);
        } else if ($filterByEmail) {
            $email = $criteria['email'];

            $queryBuilder
                ->andWhere('u.email = :email')
                ->setParameter('email', $email);
        } else if($filterById) {
            $id = $criteria['id'];

            $queryBuilder
                ->andWhere('u.id = :id')
                ->setParameter('id', $id);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername($email): ?User
    {
        return
            $this->createQueryBuilder('u')
                ->andWhere('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();
    }
}
