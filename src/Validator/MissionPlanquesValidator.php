<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MissionPlanquesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
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
