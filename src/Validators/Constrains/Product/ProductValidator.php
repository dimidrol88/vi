<?php

declare(strict_types=1);

namespace App\Validators\Constrains\Product;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @package App\Validators\Constrains\Product
 */
class ProductValidator extends ConstraintValidator
{
    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * @inheritDoc
     */
    public function validate($values, Constraint $constraint)
    {
        $products = $this->products->findExistsProductsByIds($values);

        if ($ids = array_diff($values, $products)) {
            $this->context
                ->buildViolation($constraint->message . ': ' . implode(',',$ids))
                ->addViolation();
        }
    }
}