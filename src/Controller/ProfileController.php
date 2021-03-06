<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/my-profile", name="my_profile", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {

       return $this->render('my_profile.html.twig');
    }
}
