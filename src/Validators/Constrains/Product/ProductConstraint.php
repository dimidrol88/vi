<?php

declare(strict_types=1);

namespace App\Validators\Constrains\Product;

use Symfony\Component\Validator\Constraint;

/**
 * Class SlugValidator
 * @package App\Validators\Constrains\Product
 * @Annotation
 */
class ProductConstraint extends Constraint
{
    public $message = 'Product not exist';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return ProductValidator::class;
    }
}