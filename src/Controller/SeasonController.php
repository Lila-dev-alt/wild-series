<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/season")
 */
class SeasonController extends AbstractController
{
    /**
     * @Route("/", name="season_index", methods={"GET"})
     */
    public function index(SeasonRepository $seasonRepository): Response
    {
        return $this->render('season/index.html.twig', [
            'seasons' => $seasonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="season_new", methods={"GET","POST"})
     * @param Request $request
     * @param Program $program
     * @return Response
     */
    public function new(Request $request, Program $program): Response
    {
        $season = new Season();

        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $season->setProgram($program);

            $entityManager->persist($season);
            $entityManager->flush();

            return $this->redirectToRoute('season_index');
        }

        return $this->render('season/new.html.twig', [
            'season' => $season,
            'form' => $form->createView(),
            'program'=>$program
        ]);
    }

    /**
     * @Route("/{id}", name="season_show", methods={"GET"})
     * @param Season $season
     * @return Response
     */
    public function show(Season $season): Response
    {
        return $this->render('season/show.html.twig', [
            'season' => $season,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="season_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Season $season): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('season_index');
        }

        return $this->render('season/edit.html.twig', [
            'season' => $season,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="season_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Season $season): Response
    {
        if ($this->isCsrfTokenValid('delete'.$season->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($season);
            $entityManager->flush();
        }

        return $this->redirectToRoute('season_index');
    }
}
