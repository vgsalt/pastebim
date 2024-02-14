<?php

namespace App\Controller;

use App\Entity\Paste;
use App\Entity\PasteForm;
use App\Form\PasteType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasteController extends AbstractController
{
    #[Route("/paste/create", "create")]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $paste = new PasteForm();

        $form = $this->createForm(PasteType::class, $paste);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Nå kan vi drive med formen.
            $form = $form->getData();
            // Lag tilfeldig navn
            $unique = bin2hex(random_bytes(4));
            // Lagre fil
            file_put_contents("files/$unique", $paste->getFile());
            // Få tak i dato
            $time = time();
            // Lagre til database.

            $pasteDb = new Paste();
            $pasteDb->setName($paste->getName());
            $pasteDb->setDate($time);
            $pasteDb->setLanguage($paste->getLanguage());
            $pasteDb->setUniqueId($unique);
            $pasteDb->setFile("files/$unique");

            // lagre, sånn faktisk
            $entityManager->persist($pasteDb);
            // Gjør det
            $entityManager->flush();

            // Send brukeren til pasten.
            return new RedirectResponse("/paste/$unique");
        }

        return $this->render("paste/create.html.twig", [
            'form' => $form
        ]);
    }

    #[Route("/paste/{id}", "paste")]
    public function paste(Request $request, EntityManagerInterface $entityManager, string $id)
    {
        // Skaff tak i data fra databasen.
        $paste = $entityManager->getRepository(Paste::class)->findOneBy(
            [
                'unique_id' => $id
            ]
        );

        // Hvis ingenting ble funnet
        if (!$paste) {
            throw $this->createNotFoundException(
                'Fant ikke paste ' . $id
            );
        }

        return $this->render('paste/paste.html.twig', [
            'name' => $paste->getName(),
            'date' => $paste->getDate(),
            'language' => $paste->getLanguage(),
            'paste' => file_get_contents($paste->getFile())
        ]);
    }
}