<?php

namespace App\Controller;

use App\Api\InpostApiService;
use App\Form\InpostSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InpostSearchController extends AbstractController
{
    private InpostApiService $inpostApiService;

    public function __construct(InpostApiService $inpostApiService)
    {
        $this->inpostApiService = $inpostApiService;
    }

    #[Route('/inpost/search', name: 'inpost_search')]
    public function search(Request $request): Response
    {
        $form = $this->createForm(InpostSearchType::class);
        $form->handleRequest($request);

        $points = null;
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $jsonResponse = $this->inpostApiService->fetch('points', ['city' => $data['city']]);
                $points = json_decode($jsonResponse, true);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        return $this->render('inpost/search.html.twig', [
            'form' => $form->createView(),
            'points' => $points,
            'error' => $error ?? $form->getErrors(),
        ]);
    }
}