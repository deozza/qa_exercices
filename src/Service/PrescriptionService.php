<?php

namespace App\Service;

use App\Entity\Appointment;
use App\Entity\Medicine;
use App\Entity\Prescription;
use App\Repository\PrescriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class PrescriptionService
{
    private $entityManager;
    private $prescriptionRepository;

    public function __construct(EntityManagerInterface $entityManager, PrescriptionRepository $prescriptionRepository)
    {
        $this->entityManager = $entityManager;
        $this->prescriptionRepository = $prescriptionRepository;
    }

    public function createPrescription(\DateTime $dateStart, \DateTime $dateEnd, Medicine $medicine, int $quantity, string $dosage, Appointment $appointment): Prescription
    {
        if (!$this->checkMedicineStock($medicine, $quantity)) {
            throw new \Exception('Not enough stock');
        }

        $medicine->setStock($medicine->getStock() - $quantity);

        $prescription = new Prescription();
        $prescription->setDateStart($dateStart);
        $prescription->setDateEnd($dateEnd);
        $prescription->setQuantity($quantity);
        $prescription->setDosage($dosage);
        $prescription->setAppointment($appointment);
        $prescription->setMedicine($medicine);

        return $prescription;
    }

    private function checkMedicineStock(Medicine $medicine, int $quantity): bool
    {
        if ($medicine->getStock() < $quantity) {
            return false;
        }

        return true;
    }

    public function getPrescriptionById(int $id): ?Prescription
    {
        return $this->prescriptionRepository->find($id);
    }

    public function getAllPrescriptions(): array
    {
        return $this->prescriptionRepository->findAll();
    }

    public function updatePrescription(Prescription $prescription, \DateTime $dateStart, \DateTime $dateEnd, Medicine $medicine, int $quantity, string $dosage, Appointment $appointment)
    {
        $prescription->setDateStart($dateStart);
        $prescription->setDateEnd($dateEnd);
        $prescription->setQuantity($quantity);
        $prescription->setDosage($dosage);
        $prescription->setAppointment($appointment);
        $prescription->setMedicine($medicine);

        return $prescription;
    }

    public function deletePrescription(Prescription $prescription)
    {
        $this->entityManager->remove($prescription);
        $this->entityManager->flush();
    }
}
