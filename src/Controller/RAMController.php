<?php

namespace App\Controller;

use App\Entity\RAM;
use App\Form\RAMFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RAMController extends AbstractController
{
    /**
     * @Route("/ram", name="ram")
     */
    public function index()
    {
        $ram = $this->getDoctrine()->getRepository(RAM::class)->findAll();
        return $this->render(
            'ram/index.html.twig',
            [
                'RAMs' => $ram,
            ]
        );
    }

    /**
     * 
     * @Route("/RAMCreate", name="createRAM")
     */
    public function createRAM(Request $request)
    {
        $ram = new RAM();
        $form = $this->createForm(RAMFormType::class, $ram);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ram);
            $manager->flush();
            $this->addFlash("succsess", "A new ram already be added to DB_Shop");
            return $this->redirectToRoute('ram');;
        }
        return $this->render('ram/createRAM.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/ram/Update/{id}", name="updateRAM")
     */
    public function updateRAM(Request $request, $id)
    {
        $ram = $this->getDoctrine()->getRepository(RAM::class)->find($id);
        $form = $this->createForm(RAMFormType::class, $ram);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ram);
            $manager->flush();
            $this->addFlash("succsess", "A new ram already be updated to DB_Shop");
            return $this->redirectToRoute('ram');;
        }
        return $this->render('ram/updateRAM.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * 
     * @Route("/ram/delete/{id}", name="deleteRAM")
     */
    public function deleteRAM(Request $request, $id)
    {
        try {
            $ram = $this->getDoctrine()->getRepository(RAM::class)->find($id);
            if ($ram == null) {
                $this->addFlash("Error!", "ID is invalid");
                return $this->redirectToRoute('ram');
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($ram);
            $manager->flush();
            $this->addFlash("delete succsessful !!!", "A ram already be deleted out of DB_Shop");
            return $this->redirectToRoute('ram');;
        } catch (\Exception $e) {
            return new Response(
                json_encode(["error" => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                [
                    "content-type" => "application/json"
                ]
            );
        }
    }
    /**
     * @Route("/ram/detail/{id}", name="detailRAM")
     */
    public function detailRAM(Request $request, $id)
    {
        $ram = $this->getDoctrine()->getRepository(RAM::class)->find($id);
        if ($ram == null) {
            $this->addFlash("Error", "NOT FOUND");
            return $this->redirectToRoute('ram');
        }
        return $this->render(
            'ram/detailRAM.html.twig',
            [
                'RAMs' => $ram,
            ]
        );
    }
}
