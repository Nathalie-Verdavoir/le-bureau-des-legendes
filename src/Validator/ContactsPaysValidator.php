<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContactsPaysValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint \App\Validator\ContactsPays */

        $values = $this->context->getRoot()->getData();
        foreach($values->getContacts() as $contact)
            if($values->getPays()->getId()!==$contact->getNationalite()->getId()){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ pays }}', $values->getPays())
                    ->setParameter('{{ contact }}', $contact->getNomDeCode())
                    ->addViolation();
        }
    }
}
