<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GenreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Genre::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Catégorie de chanson')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une catégorie')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un genre de chanson');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label'),
            
        ];
    }

    //function pour agir sur les boutons d'actions
    public function configureActions(Actions $actions): Actions 
    
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW,
        fn(Action $action) => $action
        ->setIcon('fa fa-add')
        ->setLabel('Ajouter')
        ->setCssClass('btn btn-success'))

     ->update(Crud::PAGE_INDEX, Action::EDIT,
        fn(Action $action) => $action
        ->setIcon('fa fa-pen')
        ->setLabel('Modifier'))

        ->update(Crud::PAGE_INDEX, Action::DELETE,
        fn(Action $action) => $action
        ->setIcon('fa fa-trash')
        ->setLabel('Supprimer'))

        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
        fn(Action $action) => $action
        ->setLabel('Enregistrer et quitter'))

        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
        fn(Action $action) => $action
        ->setLabel('Enregistrer et continuer'))

        ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
        fn(Action $action) => $action
        ->setLabel('Enregistrer'))
        
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
        fn(Action $action) => $action
        ->setLabel('Enregistrer et ajouter un nouveau'))
    
    
    
    
    ;

    }
    
}
