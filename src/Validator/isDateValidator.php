<?php
namespace App\Validator\Constraints;

use Doctrine\Common\Annotations\Annotation;
use \Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *@Annotation
 */

class isDateValidator extends ConstraintValidator
{
public function validate($value1,$value2){
if ($value1>$value2)
{
    return ;
}
}
}

?>