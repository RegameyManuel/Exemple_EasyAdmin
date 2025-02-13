<?php

namespace App\Controller\Admin;

use App\Entity\Elephant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ElephantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Elephant::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),           // Généralement, on masque l'ID sur les formulaires
            TextField::new('name', 'Nom de l’éléphant'),
            TextField::new('color', 'Couleur de l\'éléphant'),
            NumberField::new('weight', 'Poids de l\'éléphant'),
        ];
    }



}
