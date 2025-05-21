<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\DocBlock\Description;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInPlural('Produits')->setEntityLabelInSingular('Produit');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Titre')->setHelp('Titre du produit'),
            slugField::new('slug', 'URL slug')->setTargetFieldName('name')->setHelp('URL slug'),
            TextEditorField::new('description', 'Description')->setHelp('Description du produit'),
            ImageField::new('illustration', 'Image')
                ->setHelp('Image du produit 600pxx600px')
                ->setUploadDir('/public/uploads/illustrations')
                ->setBasePath('/uploads/illustrations')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setRequired($pageName === 'new'),
            NumberField::new('price', 'Prix HT')->setHelp('Prix du produit Hors tax'),
            ChoiceField::new('tva', 'TVA')->setHelp('taux de TVA')->setChoices([
                '5,5%' => '5.5',
                '10%' => 10,
                '15%' => 15,
                '20%' => 20,
            ]),
            AssociationField::new('category', 'Categorie du produit')->setHelp('Categorie du produit'),
        ];
    }

}
