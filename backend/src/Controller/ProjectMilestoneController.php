<?php

namespace App\Controller;

use App\Entity\ProjectMilestone;
use App\Form\ProjectMilestoneType;
use App\Repository\ProjectMilestoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project_milestone')]
class ProjectMilestoneController extends AbstractController
{
    #[Route('/', name: 'app_project_milestone_index', methods: ['GET'])]
    public function index(ProjectMilestoneRepository $projectMilestoneRepository): Response
    {
        return $this->render('project_milestone/index.html.twig', [
            'project_milestones' => $projectMilestoneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_project_milestone_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjectMilestoneRepository $projectMilestoneRepository): Response
    {
        $projectMilestone = new ProjectMilestone();
        $form = $this->createForm(ProjectMilestoneType::class, $projectMilestone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectMilestoneRepository->save($projectMilestone, true);

            return $this->redirectToRoute('app_project_milestone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project_milestone/new.html.twig', [
            'project_milestone' => $projectMilestone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_milestone_show', methods: ['GET'])]
    public function show(ProjectMilestone $projectMilestone): Response
    {
        return $this->render('project_milestone/show.html.twig', [
            'project_milestone' => $projectMilestone,
        ]);
    }

    #[Route('/{id}', name: 'app_project_milestone_delete', methods: ['POST'])]
    public function delete(Request $request, ProjectMilestone $projectMilestone, ProjectMilestoneRepository $projectMilestoneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectMilestone->getId(), $request->request->get('_token'))) {
            $projectMilestoneRepository->remove($projectMilestone, true);
        }

        return $this->redirectToRoute('app_project_milestone_index', [], Response::HTTP_SEE_OTHER);
    }
}
