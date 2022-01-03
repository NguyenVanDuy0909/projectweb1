<?php

namespace App\Controller;

use App\Form\SizeFormType;
use App\Entity\Size;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SizeController extends AbstractController
{
    /**
     * @Route("/size", name="size")
     */
    public function index(): Response
    {
        $size = $this->getDoctrine()->getRepository(Size::class)->findAll();
        return $this->render(
            'size/index.html.twig',
            [
                'Sizes' => $size,
            ]
        );
    }
    /**
     * 
     * @Route("/sizeCreated", name="createSize")
     */
    public function createSize(Request $request)
    {
        $size = new Size();
        $form = $this->createForm(SizeFormType::class, $size);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($size);
            $manager->flush();
            $this->addFlash("succsess", "A new size already be added to DB_Shopson");
            return $this->redirectToRoute('size');;
        }
        return $this->render('size/createSize.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @Route("/Size/Update/{id}", name="updateSize")
     */
    public function updateSize(Request $request, $id)
    {
        $size = $this->getDoctrine()->getRepository(Size::class)->find($id);
        $form = $this->createForm(SizeFormType::class, $size);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($size);
            $manager->flush();
            $this->addFlash("succsess", "A new size already be updated to DB_Shopson");
            return $this->redirectToRoute('size');;
        }
        return $this->render('size/updateSize.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * 
     * @Route("/Size/delete/{id}", name="deleteSize")
     */
    public function deleteSize(Request $request, $id)
    {
        $size = $this->getDoctrine()->getRepository(Size::class)->find($id);
        if ($size == null) {
            $this->addFlash("Error!", "ID is invalid");
            return $this->redirectToRoute('size');
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($size);
        $manager->flush();
        $this->addFlash("delete succsessful !!!", "A size already be deleted out of DB_Shopson");
        return $this->redirectToRoute('size');;
    }

    /**
     * @Route("/Size/detail/{id}", name="detailSize")
     */
    public function detailSize(Request $request, $id)
    {
        $size = $this->getDoctrine()->getRepository(Size::class)->find($id);
        if ($size == null) {
            $this->addFlash("Error", "NOT FOUND");
            return $this->redirectToRoute('size');
        }
        return $this->render(
            'size/detailSize.html.twig',
            [
                'Sizes' => $size,
            ]
        );
    }
}
