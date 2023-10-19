<?php
namespace App\Service;

use App\Entity\Medicine;
use Doctrine\ORM\EntityManagerInterface;

class MedicineService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createMedicine(string $name, float $price, array $species): Medicine
    {
        $medicine = new Medicine();
        $medicine->setName($name);
        $medicine->setPrice($price);
        $medicine->setSpecies($species);

        return $medicine;
    }

    public function updateMedicine(Medicine $medicine, string $name, float $price, array $species): Medicine
    {
        $medicine->setName($name);
        $medicine->setPrice($price);
        $medicine->setSpecies($species);

        $this->entityManager->flush();

        return $medicine;
    }

    public function deleteMedicine(Medicine $medicine): void
    {
        $this->entityManager->remove($medicine);
        $this->entityManager->flush();
    }
}
