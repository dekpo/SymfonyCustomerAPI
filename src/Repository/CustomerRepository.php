<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Customer::class);
        $this->manager = $manager;
    }
    public function findAll(){
        return $this->findBy([],['id'=>'DESC'],10);
    }
    public function saveCustomer($firstName,$lastName,$email,$phoneNumber){
        $newCustomer = new Customer();
        $newCustomer
        ->setFirstName($firstName)
        ->setLastName($lastName)
        ->setEmail($email)
        ->setPhoneNumber($phoneNumber);
        $this->manager->persist($newCustomer);
        $this->manager->flush();
    }
    public function updateCustomer(Customer $customer, $request): Customer
    {
        $firstName = $request->request->get('firstName');
        empty($firstName)? true : $customer->setFirstName($firstName);
        $lastName = $request->request->get('lastName');
        empty($lastName)? null : $customer->setLastName($lastName);
        $email = $request->request->get('email');
        empty($email)? null : $customer->setEmail($email);
        $phoneNumber = $request->request->get('phoneNumber');
        empty($phoneNumber)? null : $customer->setPhoneNumber($phoneNumber);
        $this->manager->persist($customer);
        $this->manager->flush();

        return $customer;
    }

    // /**
    //  * @return Customer[] Returns an array of Customer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Customer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
