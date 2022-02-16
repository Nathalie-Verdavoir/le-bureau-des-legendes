<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CiblesAgents extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */ 
    public $message = 'L\'agent {{ agent }} et la cible {{ cible }} ne peuvent être originaire du même pays ({{ pays }})!';
}
