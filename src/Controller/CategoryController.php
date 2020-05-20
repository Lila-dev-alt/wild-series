<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/category")
 */
class CategoryController extends AbstractController
{

    /**
     *
     * @Route("/add", name="category_add")
     * @param Request $request
     * @return Response A response instance
     */
    public function add( Request $request):Response
{
    $message = "";
    $category = new Category();
    $form = $this->createForm(CategoryType::class, $category);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($data);
        $entityManager->flush();
        $message = "Vous avez bien ajouté la catégorie : " . $data->getName();
    }
    return $this->render('category/add.html.twig', [
        'form' => $form->createView(),
        'message'=> $message
    ]);
}


}