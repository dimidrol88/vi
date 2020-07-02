<?php

namespace App\UseCases\Order\Create;

use App\Entity\User;
use App\Validators\Constrains as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var int
     * @Assert\NotBlank
     */
    public $userId;
    /**
     * @var array
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\Positive()
     * })
     * @AppAssert\Product\ProductConstraint()
     */
    public $products = [];

    public function __construct()
    {
        $this->userId = User::DEFAULT_USER_ID;
    }
}