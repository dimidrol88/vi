<?php

namespace App\UseCases\Order\Create;

use App\Entity\Order\Item;
use App\Entity\Order\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\Order\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class Handler
{
    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->orders = $em->getRepository(Order::class);
        $this->products = $em->getRepository(Product::class);
    }

    /**
     * @param Command $command
     * @return Order
     * @throws ConnectionException
     * @throws Exception
     */
    public function create(Command $command): Order
    {
        $products = $this->products->findAllByIds($command->products);

        $this->em->getConnection()->beginTransaction();

        try {
            $order = new Order(User::DEFAULT_USER_ID);

            $items = [];
            foreach ($products as $product) {
                $items[] = new Item($product, $order);
            }
            $order->addItems($items);
            $order->setPrice();

            $this->em->persist($order);

            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (Exception $exception) {
            $this->em->getConnection()->rollBack();
            throw $exception;
        }

        return $order;
    }
}