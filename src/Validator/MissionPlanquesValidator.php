<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MissionPlanquesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $values = $this->context->getRoot()->getData();
        
        if($values->getPays()->getId()!==$values->getPlanques()[0]->getPays()->getId()){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

        
    }
}
