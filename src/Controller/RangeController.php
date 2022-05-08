<?php

namespace App\Controller;

use App\Entity\Range;
use App\Form\RangeType;
use App\Repository\RangeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/range")
 */
class RangeController extends AbstractController
{
    /**
     * @Route("/", name="app_range_index", methods={"GET"})
     */
    public function index(RangeRepository $rangeRepository): Response
    {
        return $this->render('range/index.html.twig', [
            'ranges' => $rangeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_range_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RangeRepository $rangeRepository): Response
    {
        $range = new Range();
        $form = $this->createForm(RangeType::class, $range);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rangeRepository->add($range);
            return $this->redirectToRoute('app_range_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('range/new.html.twig', [
            'range' => $range,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_range_show", methods={"GET"})
     */
    public function show(Range $range): Response
    {
        return $this->render('range/show.html.twig', [
            'range' => $range,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_range_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Range $range, RangeRepository $rangeRepository): Response
    {
        $form = $this->createForm(RangeType::class, $range);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rangeRepository->add($range);
            return $this->redirectToRoute('app_range_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('range/edit.html.twig', [
            'range' => $range,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_range_delete", methods={"POST"})
     */
    public function delete(Request $request, Range $range, RangeRepository $rangeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$range->getId(), $request->request->get('_token'))) {
            $rangeRepository->remove($range);
        }

        return $this->redirectToRoute('app_range_index', [], Response::HTTP_SEE_OTHER);
    }
}
