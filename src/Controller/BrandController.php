<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function PHPUnit\Framework\throwException;

class BrandController extends AbstractController
{
    /**
     * @Route("/brand", name="brand")
     */
    public function index()
    {
        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAll();
        return $this->render(
            'brand/index.html.twig',
            [
                'Brands' => $brands,
            ]
        );
    }

    /**
     
     * @Route("/brandCreate", name="createBrand")
     */
    public function createBrand(Request $request)
    {
        $brand = new Brand();
        $form = $this->createForm(BrandFormType::class, $brand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $brand->getImage();
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
            $brand->setImage($imageName);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($brand);
            $manager->flush();
            $this->addFlash("succsess", "A new brand already be added to DB_Shop");
            return $this->redirectToRoute('brand');;
        }
        return $this->render('brand/createBrand.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     
     * @Route("/brand/Update/{id}", name="updateBrand")
     */
    public function updateBrand(Request $request, $id)
    {
        $brand = $this->getDoctrine()->getRepository(Brand::class)->find($id);
        $form = $this->createForm(BrandFormType ::class, $brand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file != null) {
                $image = $brand->getImage();
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
                $brand->setImage($imageName);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($brand);
            $manager->flush();
            $this->addFlash("succsess", "A new brand already be updated to DB_Shop");
            return $this->redirectToRoute('brand');;
        }
        return $this->render('brand/updateBrand.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * 
     * @Route("/brand/delete/{id}", name="deleteBrand")
     */
    public function deleteBrand(Request $request, $id)
    {
        try {
            $brand = $this->getDoctrine()->getRepository(Brand::class)->find($id);
            if ($brand == null) {
                $this->addFlash("Error", "ID is invalid");
                return $this->redirectToRoute('brand');
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($brand);
            $manager->flush();
            $this->addFlash("delete succsessful !!!", "A brand already be deleted out of DB_Shop");
            return $this->redirectToRoute('brand');;
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
     * @Route("/brand/detail/{id}", name="detailBrand")
     */
    public function detailBrand(Request $request, $id)
    {
        $brand = $this->getDoctrine()->getRepository(Brand::class)->find($id);
        if ($brand == null) {
            $this->addFlash("Error", "NOT FOUND");
            return $this->redirectToRoute('brand');
        }
        return $this->render(
            'brand/detailBrand.html.twig',
            [
                'Brands' => $brand,
            ]
        );
    }
}
