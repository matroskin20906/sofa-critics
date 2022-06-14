<?php

namespace App\Controller;

use App\Entity\Film;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FilmCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Film::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('director'),
            TextField::new('actors'),
            TextField::new('keywords'),
            ImageField::new('photo')
                ->setBasePath('filmPhotos')
                ->setUploadDir('public/filmPhotos')
                //->setUploadedFileNamePattern('[randomhash].[extension]')
        ];
    }

}
