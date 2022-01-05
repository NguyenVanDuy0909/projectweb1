<?php

namespace App\Form;

use App\Entity\CPU;
use App\Entity\RAM;
use App\Entity\Size;
use App\Entity\Brand;
use App\Entity\Demand;
use App\Entity\Laptop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LaptopFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, 
            [ 
                'label' => "Name",
                'required' => true
            ])
            ->add('madein',TextType::class, 
            [ 
                'label' => "Made in",
                'required' => true
            ])
            ->add('price',MoneyType::class,
            [
                'label' => "Price",
                'currency' => "USD"
            ])
            ->add('priceDiscount',MoneyType::class,
            [
                'label' => "Price Discount",
                'currency' => "USD"
            ])
            ->add('image',FileType::class,
            [
                'data_class' => null,
                'required' => is_null($builder->getData()->getImage())
            ])
            ->add('priceDiscount',MoneyType::class,
            [
                'label' => "Price Discount",
                'currency' => "USD"
            ])

            ->add('brand', EntityType::class,
            [
                'label' => 'Brand',
                'required' => true,
                'class' => Brand::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('cPU', EntityType::class,
            [
                'label' => 'CPU',
                'required' => true,
                'class' => CPU::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])

            ->add('demands', EntityType::class,
            [
                'label' => 'Demand(s)',
                'required' => true,
                'class' => Demand::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('rAM', EntityType::class,
            [
                'label' => 'RAM',
                'required' => true,
                'class' => RAM::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('size', EntityType::class,
            [
                'label' => 'Size',
                'required' => true,
                'class' => Size::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Laptop::class,
        ]);
    }
}
