<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $em = $this->getDoctrine();

        $projects = $em->getRepository(Project::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('default/index.html.twig', [
            'projects' => $projects,
            'categories' => $categories
        ]);
    }
}
