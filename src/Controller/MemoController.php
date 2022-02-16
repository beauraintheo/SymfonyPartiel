<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoFormType;
use App\Repository\MemoRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MemoController extends AbstractController
{
    private $memoRepository;

    public function __construct(MemoRepository $memoRepository)
    {
        $this->memoRepository = $memoRepository;
    }

    #[Route('/memo', name: 'memo')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memo = new Memo();
        $form = $this->createForm(MemoFormType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            date_default_timezone_set("Europe/Paris"); 
            $minutes = $form->get('memo_delay')->getData();
            $time = new DateTime();
            $time->add(new DateInterval('PT' . $minutes . 'M'));
            $memo->setExpirationTime($time);

            $entityManager->persist($memo);
            $entityManager->flush();
            
            return $this->redirectToRoute('show', [
                "id" => $memo->getId()
            ]);
        } else {
            $this->addFlash('error', 'error');   
        }

        return $this->render('memo/index.html.twig', [
            'controller_name' => 'MemoController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/memo/{id}', name: 'show')]
    public function show($id): Response
    {
        $memo = $this->memoRepository->find($id);

        if(new DateTime() > $memo->getExpirationTime()) {
            $response = new Response($this->render("expirate.html.twig"));
            $response->setStatusCode(410);
            return $response;
        } else {
            return $this->render('memo/show.html.twig', [
                'controller_name' => 'MemoController',
                "memo" => $memo
            ]);
        }
    }
}
