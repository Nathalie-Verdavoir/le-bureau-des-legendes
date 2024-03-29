<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MissionPlanquesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        $values = $this->context->getRoot()->getData();
        foreach($values->getPlanques() as $planque)
            if($values->getPays()->getId()!==$planque->getPays()->getId()){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ pays }}', $value)
                    ->addViolation();
        }
    }
}
