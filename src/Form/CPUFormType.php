<?php

namespace App\Form;

use App\Entity\CPU;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CPUFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name',TextType::class, 
            [ 
                'label' => "CPU Name",
                'required' => true
            ])
            ->add('Description',TextType::class, 
            [ 
                'label' => "Description",
                'required' => true
            ])
            ->add('image',FileType::class,
            [
                'data_class' => null,
                'required' => is_null($builder->getData()->getImage())
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CPU::class,
        ]);
    }
}
