<?php

namespace App\Repository\Wine;

use App\Entity\Wine\Bottle;
use App\Entity\Wine\Box;
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

    public function getWineConsumption(Box $box, string $year)
    {
        $where = sprintf("(b.empty_at >= '%s' && b.empty_at <= '%s')", sprintf('%s-01-01 00:00:00', $year), sprintf('%s-12-31 23:59:59', $year));
        if ("LAST_SIX_MONTH" == $year) {
            $date = (new \DateTime((new \DateTime('now'))->format('Y-m-01 H:i:s')))->sub(new \DateInterval('P5M'))->format('Y-m-01 00:00:00');
            $where = sprintf("b.empty_at >= '%s'", $date);
        }
        
        $sql = sprintf("SELECT count(b.id) as quantity, DATE_FORMAT(b.empty_at, '%s %s') as date, SUM(c.value)/100 as liter
                                FROM wine_bottle b 
                                INNER JOIN wine w ON w.id = b.wine_id
                                INNER JOIN wine_capacity c ON c.id = w.capacity_id
                                WHERE b.box_id = '%s' AND b.location IS NULL AND b.empty_at IS NOT NULL AND b.status = '%s' AND $where
                                GROUP BY DATE_FORMAT(b.empty_at, '%s %s')
                                ORDER BY DATE_FORMAT(b.empty_at, '%s-%s') ASC;", '%M', '%Y', $box->getId(), Bottle::STATUS_EMPTY, '%M', '%Y', '%Y', '%m');

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getWineInBoxByCountry(Box $box)
    {
        $sql = sprintf("SELECT count(b.id) as value, c.name as name, c.iso3 as code
                                FROM wine_bottle b 
                                INNER JOIN wine w ON b.wine_id = w.id
                                INNER JOIN wine_region r ON w.region_id = r.id
                                INNER JOIN country c ON r.country_id = c.id
                                WHERE b.box_id = '%s' AND b.status = '%s' AND b.empty_at IS NULL AND b.location IS NOT NULL                            
                                GROUP BY c.id
                                ;", $box->getId(), Bottle::STATUS_FULL);

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getWineBottlesInBox(Box $box)
    {
        $sql = sprintf("SELECT b.id, c.slug as color_slug, b.location, c.css_code as color_css
                                FROM wine_bottle b 
                                INNER JOIN wine w ON w.id = b.wine_id
                                INNER JOIN wine_appellation a ON w.appellation_id = a.id
                                INNER JOIN wine_color c ON w.color_id = c.id
                                WHERE b.box_id = '%s' AND b.status = '%s' AND b.empty_at IS NULL AND b.location IS NOT NULL                            
                                ;", $box->getId(), Bottle::STATUS_FULL);

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getWineConsumptionYears(Box $box)
    {
        $sql = sprintf("SELECT DATE_FORMAT(b.empty_at, '%s') as year
                                FROM wine_bottle b 
                                WHERE b.box_id = '%s' AND b.empty_at IS NOT NULL AND b.status = '%s' AND b.location IS NULL  
                                GROUP BY DATE_FORMAT(b.empty_at, '%s');", '%Y', $box->getId(), Bottle::STATUS_EMPTY, '%Y');

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getWineBottleApogee(Box $box)
    {
        $date = (new \DateTime('now'))->format('Y-m-d H:i:s');

        $sql = sprintf("SELECT b.id, b.apogee_at, CONCAT(w.name,' - ', a.name) as name, b.location, c.css_code
                                FROM wine_bottle b 
                                INNER JOIN wine w ON w.id = b.wine_id
                                INNER JOIN wine_appellation a ON w.appellation_id = a.id
                                INNER JOIN wine_color c ON w.color_id = c.id
                                WHERE b.box_id = '%s' AND b.status = '%s' AND b.empty_at IS NULL AND b.location IS NOT NULL
                                AND b.apogee_at > '%s'
                                ORDER BY b.apogee_at ASC LIMIT 5
                                ;", $box->getId(), Bottle::STATUS_FULL, $date);

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getWineBottleAlert(Box $box)
    {
        $date = (new \DateTime('now'))->format('Y-m-d H:i:s');

        $sql = sprintf("SELECT b.id, b.alert_at, CONCAT(w.name,' - ', a.name) as name, b.location, c.css_code
                                FROM wine_bottle b 
                                INNER JOIN wine w ON w.id = b.wine_id
                                INNER JOIN wine_appellation a ON w.appellation_id = a.id
                                INNER JOIN wine_color c ON w.color_id = c.id
                                WHERE b.box_id = '%s' AND b.status = '%s' AND b.empty_at IS NULL AND b.location IS NOT NULL
                                AND b.apogee_at > '%s'
                                ORDER BY b.apogee_at ASC LIMIT 5
                                ;", $box->getId(), Bottle::STATUS_FULL, $date);

        $getConnection = $this->getEntityManager()->getConnection();
        $statement = $getConnection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
}
