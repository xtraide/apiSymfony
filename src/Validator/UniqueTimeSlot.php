<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueTimeSlot extends Constraint
{
    public $message = 'Cette plage horaire est déjà réservée pour cette date.';

    public function getTimeSlots()
    {
        return self::CLASS_CONSTRAINT;
    }
}
