<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\Appointment;
use App\Entity\Doctor;
use App\Entity\Owner;
use App\Entity\Prescription;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;

class AppointmentService
{
    private $entityManager;
    private $appointmentRepository;

    public function __construct(EntityManagerInterface $entityManager, AppointmentRepository $appointmentRepository)
    {
        $this->entityManager = $entityManager;
        $this->appointmentRepository = $appointmentRepository;
    }

    public function createAppointment(Doctor $doctor, Owner $owner, Animal $animal, \DateTime $date, string $reason): Appointment
    {

        if (!$this->checkIfPersonIsAvailable($doctor->getAppointments()->toArray(), $date)) {
            throw new \Exception('Doctor is not available at this time');
        }

        if (!$this->checkIfPersonIsAvailable($owner->getAppointments()->toArray(), $date)) {
            throw new \Exception('Owner is not available at this time');
        }

        $appointment = new Appointment();
        $appointment->setDoctor($doctor);
        $appointment->setOwner($owner);
        $appointment->setAnimal($animal);
        $appointment->setDate($date); 
        $appointment->setReason($reason);

        return $appointment;
    }

    private function checkIfPersonIsAvailable(array $appointments, \DateTime $date): bool
    {
        foreach ($appointments as $appointment) {
            if($appointment instanceof Appointment === false) {
                throw new \Exception('Invalid appointment type');
            }

            if ($appointment->getDate() == $date) {
                return false;
            }
        }

        return true;
    }

    public function getAppointment(int $id): ?Appointment
    {
        return $this->appointmentRepository->find($id);
    }

    public function getAllAppointments(): array
    {
        return $this->appointmentRepository->findAll();
    }

    public function updateAppointment(Appointment $appointment): Appointment
    {
        $this->entityManager->flush();

        return $appointment;
    }

    public function deleteAppointment(Appointment $appointment): void
    {
        $this->entityManager->remove($appointment);
        $this->entityManager->flush();
    }

    public function addPrescription(Appointment $appointment, Prescription $prescription): Appointment
    {
        if(in_array($appointment->getAnimal()->getSpecies(), $prescription->getMedicine()->getSpecies()) === false) {
            throw new \Exception('Medicine is not suitable for this animal');
        }

        $appointment->addPrescription($prescription);

        return $appointment;
    }

    public function getPrescriptionsTotalPrice(Appointment $appointment): float
    {
        $price = 0;

        foreach ($appointment->getPrescriptions() as $prescription) {
            $medicine = $prescription->getMedicine();

            $price += ($medicine->getPrice() * $prescription->getQuantity());
        }

        return $price;
    }
}
