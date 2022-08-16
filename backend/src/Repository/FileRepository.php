<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<File>
 *
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function add(File $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(File $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findByTagAndProviderName(string $tag, string $providerName = null)
    {
        $qb = $this->createQueryBuilder('f')
            ->select('f.uri', 'f.id')
            ->where('JSON_CONTAINS(f.tags, :tag) = 1')
            ->setParameter('tag', '"' . $tag . '"');

        if ($providerName) {
            $qb->andWhere('f.providerName = :providerName')->setParameter('providerName', $providerName);
        }

        return $qb->getQuery()->getResult();
    }
}
