<?php

declare(strict_types=1);

namespace App\Controller;

use App\UseCases\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function count;

/**
 * @Route("/order", name="order")
 */
class OrderController extends AbstractController
{
    private $serializer;
    private $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("", name="", methods={"POST"})
     * @param Request $request
     * @param Order\Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Order\Create\Handler $handler): Response
    {
        /** @var Order\Create\Command $command */
        $command = $this->serializer->deserialize(
            $request->getContent(),
            Order\Create\Command::class,
            'json'
        );

        $violations = $this->validator->validate($command);
        if (count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 400, [], true);
        }

        $order = $handler->create($command);

        return $this->json([
            'status' => 'success',
            'data' => [
                'order_id' => $order->getId()
            ]
        ]);
    }
}
