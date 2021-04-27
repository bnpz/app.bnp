<?php
namespace App\Controller\Archive;

use App\Controller\AbstractController;
use App\Entity\Archive\Author;
use App\Entity\Archive\Authorship;
use App\Entity\Archive\Performance;
use App\Entity\Archive\Role;
use App\Entity\Base\EntityInterface;
use App\Form\Archive\PerformanceAuthorshipType;
use App\Form\Archive\PerformanceRoleType;
use App\Form\Archive\PerformanceType;
use App\Service\Archive\AuthorService;
use App\Service\Archive\AuthorshipService;
use App\Service\Archive\PerformanceService;
use App\Service\Archive\RoleService;
use Doctrine\ORM\Query\QueryException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class AuthorController
 * @package App\Controller\Archive
 *
 * @Route("/archive/authors")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="archive_author_index", methods={"GET","POST"}, defaults={"page": "1"})
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET","POST"}, name="archive_author_index_paginated")
     * @param Request $request
     * @param AuthorService $authorService
     * @param int $page
     * @return Response
     * @throws QueryException
     */
    public function index(Request $request, AuthorService $authorService, int $page): Response
    {
        $query = "";
        $searchForm = $request->request->all('form');
        if(isset($searchForm['query'])) {
            $query = $searchForm['query'];

        }
        if(trim($query)){
            $paginator = $authorService->search(
                $query,
                1,
                50,
                $request->query->get('orderBy', 'lastName'),
                $request->query->get('orderDirection', 'ASC')
            );
        }
        else{
            $paginator = $authorService->getAllPaginator(
                $page,
                50,
                $request->query->get('orderBy', 'lastName'),
                $request->query->get('orderDirection', 'ASC')

            );
        }

        $paginator->setRouteName('archive_author_index_paginated');

        return $this->render('archive/author/index.html.twig', [
            'authors' => $paginator->getResults(),
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/{id<[1-9]\d*>}", name="archive_author_show", methods={"GET"})
     * @param Author $author
     * @return Response
     */
    public function show(Author $author): Response
    {
        return $this->render('archive/author/show.html.twig', [
            'author' => $author
        ]);
    }
}