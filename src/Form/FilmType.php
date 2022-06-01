<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->
        add('film_picture', FileType::class, [
            'label' => 'Film Picture (PNG file)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    //'maxsize' => '1024k',
                    'mimeTypes' => [
                        'application/png',
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