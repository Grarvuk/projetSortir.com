<?php

namespace App\Repository;

use App\Entity\Inscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }

    /**
    * @return Sortie[] Returns an array of Sortie objects
    */
    
    public function estInscris($idParticipant, $idSortie)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.participant = :participant')
            ->setParameter('participant', $idParticipant)
            ->andWhere('s.sortie = :sortie')
            ->setParameter('sortie', $idSortie)
            ->select('COUNT(s.id) as nbInscri')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }


    
    public function deleteInscription($participant, $sortie)
    {
        $em = $this->getEntityManager();
        // $dql = DELETE  i WHERE  ;
        $dql = "DELETE FROM App\Entity\Inscription i
        WHERE i.participant = $participant
        AND i.sortie = $sortie";

        $query = $em->createQuery($dql);
        return  $query->getResult();

    }

    // /**
    //  * @return Inscription[] Returns an array of Inscription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Inscription
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
