<?php

namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/{id}", name="id")
     * @param Actor $actor
     * @return Response
     */
    public function index(Actor $actor):Response
    {
        $programs = $actor->getPrograms();
        return $this->render('actor/index.html.twig', [
            'controller_name' => 'ActorController',
            'programs'=> $programs,
            'actor'=> $actor
        ]);
    }
}
