<?php

namespace App\Services\Payment;

use App\Services\Request\RequestService;
use GuzzleHttp\Exception\GuzzleException;

class YaPaymentService implements PaymentServiceInterface
{
    private $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function confirm(): bool
    {
        $statusCode = $this->requestService->request();

        if($statusCode === 200){
            return true;
        }
        return false;
    }
}