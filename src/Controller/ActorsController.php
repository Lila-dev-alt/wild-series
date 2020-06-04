<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actors", name="actor_")
 */
class ActorsController extends AbstractController
{
    /**
     * @Route("/{id}", name="id")
     * @param Actor $actor
     * @return Response
     */
    public function index(Actor $actor):Response
    {
        $programs = $actor->getPrograms();
        return $this->render('index_actors.html.twig', [
            'controller_name' => 'ActorsController',
            'programs'=> $programs,
            'actor'=> $actor
        ]);
    }
}
