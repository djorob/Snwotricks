<?php
namespace App\Repository;
use Doctrine\ORM\EntityRepository;
 
class figureRepository extends EntityRepository
{
    public function findAll()
    {
        /*return $this->getfigureManager()
           ->createQuery(
               'SELECT p FROM AppBundle:Product p ORDER BY p.name ASC'
           )
           ->getResult();*/
    }
}
