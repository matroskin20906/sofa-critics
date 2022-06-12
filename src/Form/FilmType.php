<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Image;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('director')
            ->add('actors')
            ->add('keywords')
            ->add('film_picture', Image::class, [
            'label' => 'Film Picture (PNG file)',
            'mapped' => false,
            'required' => true,
            'constraints' => [
                new Assert\Image([
                    'mimeTypes' => [
                        'image/png',
                        'image/jpg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid png file',
                ])
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}