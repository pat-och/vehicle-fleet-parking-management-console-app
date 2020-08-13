<?php

namespace App\Repository;

use App\command\fleet\domain\Geolocation;
use App\command\fleet\infra\FleetRepositoryInterface;
use App\Entity\Fleet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fleet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fleet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fleet[]    findAll()
 * @method Fleet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, Fleet::class);
    }

    // /**
    //  * @return Fleet[] Returns an array of Fleet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fleet
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function addFleet(string $userId): void
    {
        $doctrineFleet = new Fleet();
        $doctrineFleet->setUuid($userId);
        $doctrineFleet->setUserId($userId);

        $this->entityManager->persist($doctrineFleet);
        $this->entityManager->flush();

    }

    public function addVehicleToFleet(string $vehicleRegistrationNumber, string $userId, Geolocation $geolocation = null): void
    {
        // TODO: Implement addVehicleToFleet() method.
    }

    public function all(): array
    {
        return parent::findAll();
    }
}
