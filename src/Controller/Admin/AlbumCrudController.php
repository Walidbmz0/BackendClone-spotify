<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AlbumCrudController extends AbstractCrudController
{

        // On déclare des constantes

        public const ALBUM_BASE_PATH = 'upload/images/albums';

        public const ALBUM_UPLOAD_DIR = 'public/upload/images/albums';

    
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des albums')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un album')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un album');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre de l\'album'),
            // On ajoute les champs d'association avec les autres tables
            AssociationField::new('genre', 'Catégorie de l\'album'),
            AssociationField::new('artist', 'Nom de l\'artiste'),
            // Champ d'upload d'une image
            ImageField::new('imagePath', 'Choisir une image de couverture')
            ->setBasePath(self::ALBUM_BASE_PATH)
            ->setUploadDir(self::ALBUM_UPLOAD_DIR)
            ->setUploadedFileNamePattern(
                fn(UploadedFile $file): string => sprintf(
                'upload_%d_%s.%s',
                random_int(1,999),
                $file->getFileName(),
                $file->guessExtension()
            )
                ),
                DateField::new('releaseDate', 'Date de sortie de l\'album'),
                BooleanField::New('is_active'),
                DateField::new('createdAt')->hideOnForm(),
                DateField::new('updatedAt')->hideOnForm(),
                AssociationField::new('songs', 'nbr de pistes')->hideOnForm(),
            
        ];
    }
    


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

    // Persister lors de la création d'un album, on génére la date

    public function persistEntity(EntityManagerInterface $entityManager , $entityInstance):void
    {
        if(!$entityInstance instanceof Album) return;
        $entityInstance->setCreatedAt(new \DateTime()); 
        parent::persistEntity($entityManager, $entityInstance);
    }

    // Persister lors de la modification d'un album, on génére la date

    public function updateEntity(EntityManagerInterface $entityManager , $entityInstance):void
    {   
        if(!$entityInstance instanceof Album) return;
        $entityInstance->setUpdatedAt(new \DateTime()); 
        parent::updateEntity($entityManager, $entityInstance);
    }
}
