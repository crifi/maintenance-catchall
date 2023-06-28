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
        $maintenance = $maintenanceService->getResponse(
            $request->headers->get('X-Backend-Name'),
            $request->getHost()
        );
        $response = $this->render(
            'my.html.twig',
            [
                'response' => $maintenance,
            ]
        );
        $response->setStatusCode($maintenance->getHttpStatuscode());
        $response->setCache([
            'must_revalidate' => true,
            'no_cache' => true,
            'no_store' => true,
            'max_age' => 0,
        ]);
        return $response;
    }
}