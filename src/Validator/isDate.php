<?php
namespace App\Validator\Constraints;

use Doctrine\Common\Annotations\Annotation;
use \Symfony\Component\Validator\Constraint;
/**
 *@Annotation
 */

class isDate extends Constraint
{
    // public string $message = 'hdbsb';

/**
 * @return string
 */

public function validatedBy()
{
    return \get_class($this).'Validator';
}
}

?>