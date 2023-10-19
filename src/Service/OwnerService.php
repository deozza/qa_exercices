<?php
namespace App\Service;

use App\Entity\Owner;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;

class OwnerService
{
    private $entityManager;
    private $ownerRepository;

    public function __construct(EntityManagerInterface $entityManager, OwnerRepository $ownerRepository)
    {
        $this->entityManager = $entityManager;
        $this->ownerRepository = $ownerRepository;
    }

    public function createOwner(string $firstname, string $lastname, string $mail): Owner
    {
        $owner = new Owner();
        $owner->setFirstname($firstname);
        $owner->setLastname($lastname);
        $owner->setMail($mail);

        return $owner;
    }

    public function getOwnerById(int $id): ?Owner
    {
        return $this->ownerRepository->find($id);
    }

    public function updateOwner(Owner $owner, string $firstname, string $lastname, string $mail): Owner
    {
        $owner->setFirstname($firstname);
        $owner->setLastname($lastname);
        $owner->setMail($mail);

        return $owner;
    }

    public function deleteOwner(Owner $owner): void
    {
        $this->entityManager->remove($owner);
        $this->entityManager->flush();
    }
}
