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
     * @param UserRepository $userrRepository
     * @return Response
     */
    public function index(UserRepository $userrRepository): Response
    {

       return $this->render('my_profile.html.twig');
    }
}
