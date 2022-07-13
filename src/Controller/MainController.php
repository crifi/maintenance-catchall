<?php

namespace App\Controller;

use App\Services\MaintenanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Wildcard controller for all incoming requests
     *
     * @Route(
     *     "/{req}",
     *     name="maintenance",
     *     requirements={"req"="^(.)*$"},
     *     priority=-1
     * )
     *
     * @param Request $request
     * @param MaintenanceService $maintenanceService
     * @return Response
     */
    public function maintenance(Request $request, MaintenanceService $maintenanceService): Response
    {
        $response = $maintenanceService->getResponse($request->getHost());
        return $this->render(
            'my.html.twig', [
                'response' => $response,
            ],
            (new Response())->setStatusCode($response->getHttpStatuscode())
        );
    }
}