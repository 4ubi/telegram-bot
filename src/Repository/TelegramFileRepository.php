<?php

namespace App\Repository;

use App\Entity\TelegramFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TelegramFile>
 *
 * @method TelegramFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method TelegramFile|null findOneBy(array $criteria, ?array $orderBy = null)
 * @method TelegramFile[] findAll()
 * @method  TelegramFile[] findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 */
class TelegramFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TelegramFile::class);
    }

    /**
     * @param string $username
     *
     * @return TelegramFile|null
     */
    public function getRandomFileAnotherUsers(string $username): ?TelegramFile
    {
        $queryBuilder = $this->createQueryBuilder('telegram_file');

        $totalRecords = $queryBuilder
            ->select('count(telegram_file)')
            ->where('telegram_file.username != :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getSingleScalarResult()
        ;

        if ($totalRecords < 1) {
            return null;
        }

        $rowToFetch = rand(0, $totalRecords-1);

        return $queryBuilder
            ->select('telegram_file')
            ->setMaxResults(1)
            ->setFirstResult($rowToFetch)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_OBJECT)
        ;
    }

}