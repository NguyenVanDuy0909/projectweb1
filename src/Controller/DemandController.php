<?php

namespace App\Controller;

use App\Entity\Demand;
use App\Form\DemandFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandController extends AbstractController
{
    /**
     * @Route("/demand", name="demand")
     */
    public function index()
    {
        $demand = $this->getDoctrine()->getRepository(Demand::class)->findAll();
        return $this->render(
            'demand/index.html.twig',
            [
                'Demands' => $demand,
            ]
        );
    }

    /**
     *
     * @Route("/demandCreate", name="createDemand")
     */
    public function createDemand(Request $request)
    {
        $demand = new Demand();
        $form = $this->createForm(DemandFormType::class, $demand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($demand);
            $manager->flush();
            $this->addFlash("succsess", "A new demand already be added to DB_Shop");
            return $this->redirectToRoute('demand');;
        }
        return $this->render('demand/createDemand.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * 
     * @Route("/demand/Update/{id}", name="updateDemand")
     */
    public function updateDemand(Request $request, $id)
    {
        $demand = $this->getDoctrine()->getRepository(Demand::class)->find($id);
        $form = $this->createForm(DemandFormType::class, $demand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($demand);
            $manager->flush();
            $this->addFlash("succsess", "A new demand already be updated to DB_Shop");
            return $this->redirectToRoute('demand');;
        }
        return $this->render('demand/updateDemand.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     *
     * @Route("/demand/delete/{id}", name="deleteDemand")
     */
    public function deleteDemand(Request $request, $id)
    {
        try {
            $demand = $this->getDoctrine()->getRepository(Demand::class)->find($id);
            if ($demand == null) {
                $this->addFlash("Error!", "ID is invalid");
                return $this->redirectToRoute('demand');
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($demand);
            $manager->flush();
            $this->addFlash("delete succsessful !!!", "A demand already be deleted out of DB_Shop");
            return $this->redirectToRoute('demand');;
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
     * @Route("/demand/detail/{id}", name="detailDemand")
     */
    public function detailDemand(Request $request, $id)
    {
        $demand = $this->getDoctrine()->getRepository(Demand::class)->find($id);
        if ($demand == null) {
            $this->addFlash("Error","NOT FOUND");
            return $this->redirectToRoute('demand');
        }
        return $this->render(
            'demand/detailDemand.html.twig',
            [
                'Demands' => $demand,
            ]
        );
    }
}
