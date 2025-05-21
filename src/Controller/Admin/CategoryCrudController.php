<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    /**
     *
     * @param Crud $crud
     * @return Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Categorie')
            ->setEntityLabelInPlural('Categories');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'titre')->setHelp('Titre de la categorie'),
            SlugField::new('slug', 'url')->setTargetFieldName('name')->setHelp('URL slug'),
            TextEditorField::new('description', 'description')->setHelp('Description de la categorie'),
        ];
    }

}
