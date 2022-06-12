<?php

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            TextField::new('password'),
            ImageField::new('photo')
            ->setBasePath('userPhotos')
            ->setUploadDir('public/userPhotos')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(true),
        ];
    }
}
