<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StreetPostalCodeDependency extends Constraint
{
    public string $message = 'Jeśli podano ulicę, kod pocztowy jest wymagany.';

    public function validatedBy(): string
    {
        return StreetPostalCodeDependencyValidator::class;
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
