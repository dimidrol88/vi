<?php

namespace App\UseCases\Order\Pay;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var int
     * @Assert\NotBlank
     */
    public $userId;
    /**
     * @var float
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value=0.00)
     */
    public $price;
    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Positive()
     */
    public $order;

    public function __construct()
    {
        $this->userId = User::DEFAULT_USER_ID;
    }
}