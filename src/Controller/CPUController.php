<?php

namespace App\Controller;

use App\Entity\CPU;
use App\Form\CPUFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function PHPUnit\Framework\throwException;

class CPUController extends AbstractController
{
    /**
     * @Route("/cpu", name="cpu")
     */
    public function index()
    {
        $cpu = $this->getDoctrine()->getRepository(CPU::class)->findAll();
        return $this->render(
            'cpu/index.html.twig',
            [
                'CPUs' => $cpu,
            ]
        );
    }

    /**
     * 
     * @Route("/cpuCreate", name="createCPU")
     */
    public function createCPU(Request $request)
    {
        $cpu = new CPU();
        $form = $this->createForm(CPUFormType::class, $cpu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $cpu->getImage();
            $fileName = md5(uniqid());
            $fileExtension = $image->guessExtension();
            $imageName = $fileName . '.' . $fileExtension;
            try {
                $image->move(
                    $this->getParameter('laptop_image'),
                    $imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }
            $cpu->setImage($imageName);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($cpu);
            $manager->flush();
            $this->addFlash("succsess", "A new cpu already be added to DB_Shop");
            return $this->redirectToRoute('cpu');;
        }
        return $this->render('cpu/createCPU.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * 
     * @Route("/cpu/Update/{id}", name="updateCPU")
     */
    public function updateCPU(Request $request, $id)
    {
        $cpu = $this->getDoctrine()->getRepository(CPU::class)->find($id);
        $form = $this->createForm(CPUFormType::class, $cpu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();
            if ($file != null) {
                $image = $cpu->getImage();
                $imgName = uniqid();
                $imgExtension = $image->guessExtension();
                $imageName = $imgName . "." . $imgExtension;
                try {
                    $image->move(
                        $this->getParameter('laptop_image'),
                        $imageName
                    );
                } catch (FileException $e) {
                    throwException($e);
                }
                $cpu->setImage($imageName);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($cpu);
            $manager->flush();
            $this->addFlash("succsess", "A new cpu already be updated to DB_Shop");
            return $this->redirectToRoute('cpu');;
        }
        return $this->render('cpu/updateCPU.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * 
     * @Route("/cpu/delete/{id}", name="deleteCPU")
     */
    public function deleteCPU(Request $request, $id)
    {
        try {
            $cpu = $this->getDoctrine()->getRepository(CPU::class)->find($id);
            if ($cpu == null) {
                $this->addFlash("Error", "ID is invalid");
                return $this->redirectToRoute('cpu');
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($cpu);
            $manager->flush();
            $this->addFlash("delete succsessful !!!", "A cpu already be deleted out of DB_Shop");
            return $this->redirectToRoute('cpu');;
        } catch (\Exception $e) {
            return new Response(
                json_encode(["Error" => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                [
                    "content-type" => "application/json"
                ]
            );
        }
    }
    /**
     * @Route("/cpu/detail/{id}", name="detailCPU")
     */
    public function detailCPU(Request $request, $id)
    {
        $cpu = $this->getDoctrine()->getRepository(CPU::class)->find($id);
        if ($cpu == null) {
            $this->addFlash("Error", "NOT FOUND");
            return $this->redirectToRoute('cpu');
        }
        return $this->render(
            'cpu/detailCPU.html.twig',
            [
                'CPUs' => $cpu,
            ]
        );
    }
}
