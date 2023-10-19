<?php
namespace App\Service;

use App\Entity\Animal;
use App\Entity\Owner;
use Doctrine\ORM\EntityManagerInterface;

class AnimalService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAnimal(string $name, string $species, \DateTime $birth, Owner $owner): Animal
    {
        $animal = new Animal();
        $animal->setName($name);
        $animal->setSpecies($species);
        $animal->setBirth($birth);
        $animal->setOwner($owner);
        
        return $animal;
    }

    public function getAnimal(int $id): ?Animal
    {
        return $this->entityManager->getRepository(Animal::class)->find($id);
    }

    public function getAllAnimals(): array
    {
        return $this->entityManager->getRepository(Animal::class)->findAll();
    }

    public function updateAnimal(int $id, string $name, string $species, int $age): Animal
    {
        $animal = $this->entityManager->getRepository(Animal::class)->find($id);

        if (!$animal) {
            throw new \Exception('Animal not found');
        }

        $animal->setName($name);
        $animal->setSpecies($species);
        $animal->setAge($age);

        $this->entityManager->flush();

        return $animal;
    }

    public function deleteAnimal(int $id): void
    {
        $animal = $this->entityManager->getRepository(Animal::class)->find($id);

        if (!$animal) {
            throw new \Exception('Animal not found');
        }

        $this->entityManager->remove($animal);
        $this->entityManager->flush();
    }
}
