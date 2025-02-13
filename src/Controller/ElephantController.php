<?php

namespace App\Controller;

use App\Entity\Elephant;
use App\Form\ElephantType;
use App\Repository\ElephantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/elephant')]
final class ElephantController extends AbstractController
{
    #[Route(name: 'app_elephant_index', methods: ['GET'])]
    public function index(ElephantRepository $elephantRepository): Response
    {
        return $this->render('elephant/index.html.twig', [
            'elephants' => $elephantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_elephant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $elephant = new Elephant();
        $form = $this->createForm(ElephantType::class, $elephant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($elephant);
            $entityManager->flush();

            return $this->redirectToRoute('app_elephant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('elephant/new.html.twig', [
            'elephant' => $elephant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_elephant_show', methods: ['GET'])]
    public function show(Elephant $elephant): Response
    {
        return $this->render('elephant/show.html.twig', [
            'elephant' => $elephant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_elephant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Elephant $elephant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ElephantType::class, $elephant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_elephant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('elephant/edit.html.twig', [
            'elephant' => $elephant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_elephant_delete', methods: ['POST'])]
    public function delete(Request $request, Elephant $elephant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$elephant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($elephant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_elephant_index', [], Response::HTTP_SEE_OTHER);
    }
}
