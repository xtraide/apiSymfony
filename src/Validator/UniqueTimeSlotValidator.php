<?php

namespace App\Validator;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueTimeSlotValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueTimeSlot) {
            throw new UnexpectedTypeException($constraint, UniqueTimeSlot::class);
        }

        if (!$value instanceof Reservation) {
            throw new UnexpectedValueException($value, Reservation::class);
        }

        $existingReservations = $this->entityManager->getRepository(Reservation::class)
            ->findBy(['date' => $value->getDate(), 'timeSlot' => $value->getTimeSlot()]);

        if (count($existingReservations) > 0) {
            $this->context->buildViolation($constraint->message)
                ->atPath('timeSlot')
                ->addViolation();
        }
    }
}
