<?php


namespace App\Controller;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
public function index ()
{
    $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findAll();
    return $this->render('home.html.twig', [
        'bienvenue'=> 'Bienvenue sur Wild Series !',
        'programs'=> $programs
    ]);
}
}
