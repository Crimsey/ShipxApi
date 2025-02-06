<?php

namespace App\Controller;

use App\Form\InpostSearchType;
use App\Api\InpostApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InpostSearchController extends AbstractController
{
    private InpostApiClient $inpostApiClient;

    public function __construct(InpostApiClient $inpostApiClient)
    {
        $this->inpostApiClient = $inpostApiClient;
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
                $jsonResponse = $this->inpostApiClient->fetch('points', ['city' => $data['city']]);
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