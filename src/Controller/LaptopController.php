<?php

namespace App\Controller;

use App\Entity\Laptop;
use App\Form\LaptopFormType;
use App\Repository\LaptopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function PHPUnit\Framework\throwException;

class LaptopController extends AbstractController
{
    #[Route('/laptop', name: 'laptop')]
    public function index(): Response
    {
        $laptops = $this->getDoctrine()->getRepository(Laptop::class)->findAll();
        return $this->render(
            'laptop/index.html.twig',
            [
                'laptops' => $laptops,
            ]
        );
    }

    /**
     * @Route("/laptop/detail/{id}", name="detailLaptop")
     */
    public function detailLaptop(Request $request, $id)
    {
        $laptop = $this->getDoctrine()->getRepository(Laptop::class)->find($id);
        if ($laptop == null) {
            $this->addFlash("Error", "NOT FOUND");
            return $this->redirectToRoute("laptop");
        }
        return $this->render(
            'laptop/detailLaptop.html.twig',
            [
                'laptop' => $laptop,
            ]
        );
    }


    /**
     *
     * @Route("/laptop/delete/{id}", name="deleteLaptop")
     */
    public function deleteLaptop(Request $request, $id): Response
    {
        $laptop = $this->getDoctrine()->getRepository(Laptop::class)->find($id);
        if ($laptop == null) {
            $this->addFlash("Error", "ID is invalid");
            return $this->redirectToRoute('(laptop)');
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($laptop);
        $manager->flush();
        $this->addFlash("delete successful !!!", " A Laptop already be delete out of Database");
        return $this->redirectToRoute('laptop');
    }


    /**
     * 
     * @Route("/laptopCreate", name="createLaptop")
     */
    public function createLaptop(Request $request)
    {
        $laptop = new Laptop();
        $form = $this->createForm(LaptopFormType::class, $laptop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $laptop->getImage();
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
            $laptop->setImage($imageName);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($laptop);
            $manager->flush();
            $this->addFlash("succsess", "A new laptop already be added to DB_Shop");
            return $this->redirectToRoute('laptop');
        }
        return $this->render('laptop/createLaptop.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     * 
     * @Route("/laptop/update/{id}", name="updateLaptop")
     */
    public function updateLaptop(Request $request, $id)
    {
        $laptop = $this->getDoctrine()->getRepository(Laptop::class)->find($id);
        $form = $this->createForm(LaptopFormType::class, $laptop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file != null) {
                $image = $laptop->getImage();
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
                $laptop->setImage($imageName);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($laptop);
            $manager->flush();
            $this->addFlash("succsess", "A new laptop already be updated to DB_Shop");
            return $this->redirectToRoute('laptop');;
        }
        return $this->render('laptop/updateLaptop.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/laptop/sort/asc", name="sort_laptop_id_asc")
     */
    public function sortLaptopByIdAsc(LaptopRepository $repository)
    {
        $laptops = $repository->sortIdAsc();
        return $this->render(
            "laptop/index.html.twig",
            [
                'laptops' => $laptops
            ]
        );
    }

    /**
     * @Route("/laptop/sort/desc", name="sort_laptop_id_desc")
     */
    public function sortLaptopByIdDesc(LaptopRepository $repository)
    {
        $laptops = $repository->sortIdDesc();
        return $this->render(
            "laptop/index.html.twig",
            [
                'laptops' => $laptops
            ]
        );
    }

    /**
     * @Route("/laptop/search", name="search_laptop_name")
     */
    public function searchLaptopByTitle(LaptopRepository $repository, Request $request)
    {
        $name = $request->get("name");
        $laptops = $repository->searchLaptop($name);
        return $this->render(
            "laptop/index.html.twig",
            [
                'laptops' => $laptops
            ]
        );
    }
}
