<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
       return $crud
           ->setEntityLabelInSingular('Utilisateur')
           ->setEntityLabelInPlural('Utilisateurs');
    }

        public function configureFields(string $pageName): iterable
        {
            return [
                EmailField::new('email', 'Email')->onlyOnIndex(),
                TextField::new('firstname', 'Prénom'),
                TextField::new('lastname', 'Nom'),
            ];
        }
}
