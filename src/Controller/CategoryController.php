<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
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
     * @return Response A response instance
     */
    public function add():Response
{
    $category = new Category();
    $form = $this->createForm(CategoryType::class, $category);
    return $this->render('category/add.html.twig', [
        'form' => $form->createView(),
    ]);
}


}