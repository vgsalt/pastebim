<?php

namespace App\Controller;

use App\Entity\Paste;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route("/", "index")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Hent fra database
        $repo = $entityManager->getRepository(Paste::class);
        $paster = $repo->findAll();

        return $this->render("index.html.twig", [
            'paster' => $paster
        ]);
    }
}