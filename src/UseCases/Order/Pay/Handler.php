<?php

namespace App\UseCases\Order\Pay;

use App\Entity\Order\Order;
use App\Repository\Order\OrderRepository;
use App\Services\Payment\PaymentServiceInterface;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Exception;

class Handler
{
    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PaymentServiceInterface
     */
    private $paymentService;

    /**
     * @param EntityManagerInterface $em
     * @param PaymentServiceInterface $paymentService
     */
    public function __construct(EntityManagerInterface $em, PaymentServiceInterface $paymentService)
    {
        $this->em = $em;
        $this->orders = $em->getRepository(Order::class);
        $this->paymentService = $paymentService;
    }

    /**
     * @param Command $command
     * @throws ConnectionException
     * @throws Exception
     */
    public function pay(Command $command)
    {
        $order = $this->orders->findOneBy(['id' => $command->order, 'userId' => $command->userId]);

        if(!$order || !$order->isNew() || !$order->priceIsEqual($command->price)){
            throw new DomainException('Order does not exist or already paid!');
        }
        $this->em->getConnection()->beginTransaction();

        try {
            if($this->paymentService->confirm()){
                $order->setStatus(Order::STATUS_PAID);

                $this->em->persist($order);
                $this->em->flush();
                $this->em->getConnection()->commit();
            }else{
                throw new DomainException('Error paying order.');
            }

        } catch (Exception $exception) {
            $this->em->getConnection()->rollBack();
            throw $exception;
        }
    }
}