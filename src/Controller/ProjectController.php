<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Project;
use App\Form\CommentType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="project_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="project_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form['picture']->getData();

            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $project->setPicture($pictureFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $project->setUser($this->getUser());
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="project_show", methods={"GET","POST"})
     */
    public function show(Project $project, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setUser($this->getUser());
            $comment->setProject($project);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('project_show', ['slug' => $project->getSlug()] );
        }

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
            'comment' => $comment
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="project_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Project $project, FileUploader $fileUploader): Response
    {
        if ($this->getUser() !== $project->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit d'éditer ce projet");
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form['picture']->getData();

            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $project->setPicture($pictureFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->getUser() !== $project->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer ce projet");
        }

        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
