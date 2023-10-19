<?php
namespace App\Service;

use App\Entity\Doctor;
use Doctrine\ORM\EntityManagerInterface;

class DoctorService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createDoctor(string $firstname, string $lastname, string $mail): Doctor
    {
        $doctor = new Doctor();
        $doctor->setFirstname($firstname);
        $doctor->setFirstname($lastname);
        $doctor->setMail($mail);

        return $doctor;
    }

    public function updateDoctor(Doctor $doctor, string $firstname, string $lastname, string $mail): Doctor
    {
        $doctor->setFirstname($firstname);
        $doctor->setFirstname($lastname);
        $doctor->setMail($mail);

        return $doctor;
    }

    public function deleteDoctor(Doctor $doctor): void
    {
        $this->entityManager->remove($doctor);
        $this->entityManager->flush();
    }
}
