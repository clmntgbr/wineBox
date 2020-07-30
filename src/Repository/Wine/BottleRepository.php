<?php

namespace App\Repository\Wine;

use App\Entity\Wine\Bottle;
use App\Entity\Wine\Cellar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bottle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bottle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bottle[]    findAll()
 * @method Bottle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BottleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bottle::class);
    }

    public function getWineConsumption(Cellar $cellar, string $year)
    {
        $where = sprintf("(b.empty_at >= '%s' && b.empty_at <= '%s')", sprintf('%s-01-01 00:00:00', $year), sprintf('%s-12-31 23:59:59', $year));
        if ("LAST_SIX_MONTH" == $year) {
            $date = (new \DateTime((new \DateTime('now'))->format('Y-m-01 H:i:s')))->sub(new \DateInterval('P5M'))->format('Y-m-01 00:00:00');
            $where = sprintf("b.empty_at >= '%s'", $date);
        }
        
        $sql = sprintf("SELECT count(b.id) as count, DATE_FORMAT(b.empty_at, '%s %s') as date
                                FROM wine_bottle b 
                                WHERE b.cellar_id = '%s' AND b.empty_at IS NOT NULL AND b.status = '%s' AND $where
                                GROUP BY DATE_FORMAT(b.empty_at, '%s %s');", '%M', '%Y', $cellar->getId(), Bottle::STATUS_EMPTY, '%M', '%Y');

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getWineConsumptionYears(Cellar $cellar)
    {
        $sql = sprintf("SELECT DATE_FORMAT(b.empty_at, '%s') as year
                                FROM wine_bottle b 
                                WHERE b.cellar_id = '%s' AND b.empty_at IS NOT NULL AND b.status = '%s' 
                                GROUP BY DATE_FORMAT(b.empty_at, '%s');", '%Y', $cellar->getId(), Bottle::STATUS_EMPTY, '%Y');

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
}
