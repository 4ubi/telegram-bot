<?php

namespace App\Repository;

use App\Entity\UserFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserFiles>
 *
 * @method UserFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFiles|null findOneBy(array $criteria, ?array $orderBy = null)
 * @method UserFiles[] findAll()
 * @method  UserFiles[] findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 */
class UserFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFiles::class);
    }

}