<?php


namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CommentType;
use App\Form\ProgramSearchType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return Response A response instance
     */
    public function index(Request $request): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        if (!$programs) {
            throw  $this->createNotFoundException() (
                'No program found in program\'s table.'
            );
        }
        $form = $this->createForm(
            ProgramSearchType::class,
            null,
            ['method' => Request::METHOD_GET]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $programs = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findOneLikeSubmittedTitle($data['searchField']);
        }

        return $this->render('wild/index.html.twig', [
            'programs' => $programs,
            'form' => $form->createView(),
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

    /**
     * @Route("/program/{id}", name="show_program").
     * @param Program $program
     * @return Response
     */
public function showByProgram(Program $program ): Response {


    $seasons = $program->getSeasons();

    return $this->render('wild/program.html.twig', [
        'program'   => $program,
        'seasons'   => $seasons

        ]);

}

    /**
     * @Route("/seasons/{id}", name="show_season").
     * @param int $id
     * @return Response
     */
public function showBySeason(int $id): Response {
    $seasonRepository = $this->getDoctrine()->getRepository(Season::class);
    $season = $seasonRepository->findOneBy(['id' => $id]);

    $program = $season->getProgram();
    $episodes = $season->getEpisodes();

    return $this->render('wild/episodes.html.twig', [
        'id'=> $id,
        'program' => $program,
        'episodes'=> $episodes,
        'season'=> $season
    ]);
}

    /**
     * @Route("/episode/{id}", name="show_episode")
     * @param Request $request
     * @param Episode $episode
     * @return Response
     */


public function showEpisode(Request $request, Episode $episode, EntityManagerInterface $entityManager): Response {
    $season = $episode->getSeason();
    $program = $season->getProgram();
    $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
    $comments = $commentRepository->findBy(['episode' => $episode]);
    $form = $this->createForm(CommentType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $comment = $form->getData();
        $comment->setAuthor($this->getUser());
        $comment->setEpisode($episode);
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('show_episode', ['id'=>$episode->getId()]);
    }
    return $this->render('wild/episode.html.twig', ['episode'=>$episode,
        'season'=> $season,
        'program'=> $program,
        'comments'=> $comments,
        'form' => $form->createView(),
        ]);
}
    /**
     * @Route("/actor/{id}", name="id")
     * @param Actor $actor
     * @return Response
     */
    public function showActor(Actor $actor):Response
    {
        $programs = $actor->getPrograms();
        return $this->render('index_actors.html.twig', [
            'programs'=> $programs,
            'actor'=> $actor
        ]);
    }

    public function AllCategories():Response
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        return $this->render('categories.html.twig', [
            'categories'=> $categories
        ]);
    }
}
