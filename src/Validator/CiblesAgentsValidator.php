<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CiblesAgentsValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var $constraint \App\Validator\CiblesAgents */

        $values = $this->context->getRoot()->getData();
        foreach($values->getAgents() as $agent)
        foreach($values->getCibles() as $cible)
            if($agent->getNationalite()===$cible->getNationalite()){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ agent }}', $agent->getNomDeCode())
                    ->setParameter('{{ cible }}', $cible->getNomDeCode()) 
                    ->setParameter('{{ pays }}', $agent->getNationalite())
                    ->addViolation();
        }
    }
}
