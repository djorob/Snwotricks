<?php
namespace App\Repository;
use Doctrine\ORM\EntityRepository;
 
class forumRepository extends EntityRepository
{
    public function findAll()
    {
        /*return $this->getfigureManager()
           ->createQuery(
               'SELECT p FROM AppBundle:Product p ORDER BY p.name ASC'
           )
           ->getResult();*/

           $query = $this->createQueryBuilder('forum')
                  ->orderBy('forum.date', 'DESC')
                  ->getQuery();

                 return $query->getResult();
    }
}
