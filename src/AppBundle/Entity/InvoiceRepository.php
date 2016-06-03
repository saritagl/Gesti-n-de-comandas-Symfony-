<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class InvoiceRepository extends EntityRepository
{
    public function reportBy($type, $firstDay, $lastDay){
        $parameters = array(
            "from_" => date('Y-m-d 00:00:00', $firstDay),
            "to_" => date('Y-m-d 23:59:59', $lastDay)
        );

        switch($type){
            case "table":
                $dql = 'SELECT t.number as table_number,
                            COUNT(DISTINCT i.server) as servers,
                            COUNT(i.id) as invoices,
                            SUM(i.total) as total
                        FROM AppBundle:Invoice i JOIN i.table t
                        WHERE i.createdAt >= :from_ AND i.createdAt <= :to_
                        GROUP BY t.number';
                break;
            case "server":
                $dql = 'SELECT s.username as server_name,
                            COUNT(DISTINCT i.table)as tables,
                            COUNT(i.id) as invoices,
                            SUM(i.total) as total
                        FROM AppBundle:Invoice i JOIN i.server s
                        WHERE i.createdAt >= :from_ AND i.createdAt <= :to_
                        GROUP BY s.username';
                break;
            case "total":
                $dql = 'SELECT COUNT(i.server) as servers,
                            COUNT(i.table)as tables,
                            COUNT(i.id) as invoices,
                            SUM(i.total) as total
                        FROM AppBundle:Invoice i
                        WHERE i.createdAt >= :from_ AND i.createdAt <= :to_';
                break;
        }

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters($parameters)
            ->getResult();
    }
}
