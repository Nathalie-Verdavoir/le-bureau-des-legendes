<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UnAgentAvecLaSpecialiteDeMissionValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        
        $ToutesLesSpecialitesDesAgents = [];
        /* @var $constraint \App\Validator\UnAgentAvecLaSpecialiteDeMission */
        $values = $this->context->getRoot()->getData();
        foreach($values->getAgents() as $agent){
        $spe = $agent->getSpecialites();
            if($spe && count($spe) > 0)
            {/**@var $s Specialites */
                foreach($spe as $s){
                    if (!in_array($s,$ToutesLesSpecialitesDesAgents)) {
                        $ToutesLesSpecialitesDesAgents[] = $s;
                    }
                }
            }
        }
        if (null === $value || '' === $value) {
            return;
        }

        if(!in_array( $values->getSpecialite(),$ToutesLesSpecialitesDesAgents)){
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $values->getSpecialite())
            ->addViolation();
        }
    }
}
