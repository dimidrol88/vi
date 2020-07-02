<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("", name="", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->json([
            'version' => $this->getParameter('app.version'),
        ]);
    }
}
