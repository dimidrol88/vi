<?php

namespace App\Services\Payment;

interface PaymentServiceInterface
{
    /**
     * @return bool Метод возвращает статус оплаты
     */
    public function confirm(): bool;
}