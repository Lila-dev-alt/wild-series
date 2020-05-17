<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild")
 */
class WildController extends AbstractController
{

    /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="wild_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        if (!$programs) {
            throw  $this->createNotFoundException() (
                'No program found in program\'s table.'
            );
        }

        dump($programs);
        return $this->render('wild/index.html.twig', [
            'programs' => $programs
        ]);

    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="wild_show")
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);

    }

    /**
     * @Route("/category/{categoryName}", name="show_category").
     * @param string $categoryName
     * @return Response
     */
    public function showByCategory(string $categoryName):Response
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        $programRepository = $this->getDoctrine()->getRepository(Program::class);
        $programs = $programRepository->findBy(
            ['category' => $category],
            ['id' => 'DESC'],
            3
        );


        return $this->render('wild/category.html.twig', [
            'category' => $category,
            'category_name' => $categoryName,
            'programs'=> $programs
        ]);

    }

}