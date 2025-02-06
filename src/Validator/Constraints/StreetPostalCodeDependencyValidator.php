<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StreetPostalCodeDependencyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof StreetPostalCodeDependency) {
            throw new \InvalidArgumentException(sprintf('%s jest nieprawidłowym constraintem', get_class($constraint)));
        }

        if (!is_array($value) || !isset($value['street'])) {
            return;
        }

        $street = trim($value['street'] ?? '');
        $postalCode = trim($value['postalCode'] ?? '');

        if (!empty($street) && empty($postalCode)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('postalCode')
                ->addViolation();
        }
    }
}
