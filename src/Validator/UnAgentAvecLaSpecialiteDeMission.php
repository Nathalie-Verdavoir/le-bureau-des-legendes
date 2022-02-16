<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UnAgentAvecLaSpecialiteDeMission extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Au moins un des agents doit avoir la spécalité : "{{ value }}"!';
}
