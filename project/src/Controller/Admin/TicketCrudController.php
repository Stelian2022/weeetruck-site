<?php

namespace App\Controller\Admin;

use App\Entity\Ticket;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TicketCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ticket::class;
    }


    public function configureFields(string $pageName): iterable
    {

        // yield ImageField::new('imageFilename')
        // ->setBasePath('') // Set the base path for the uploaded images
        // ->setUploadDir('public/uploads/') // Set the upload directory for the images
        // ->setUploadedFileNamePattern('[randomhash].[extension]'); // Define the file name pattern

        $imageField =   ImageField::new(propertyName: 'imageFilename')
            // ->setFormType(formTypeFqcn:VichImageType::class)
            ->setUploadDir('public/uploads/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setLabel(label: 'Image');
        $image =    ImageField::new(propertyName: 'imageFilename')
            ->setBasePath(path: "/uploads/")

            ->setLabel(label: 'Image');
        $fields = [
            IntegerField::new(propertyName: 'id', label: 'ID Ticket')->onlyOnIndex(),
            TextField::new(propertyName: 'titre'),

            TextEditorField::new(propertyName: 'description'),
            ChoiceField::new(propertyName: 'category')
                ->setChoices([
                    'Option 1' => 'option1',
                    'Option 2' => 'option2',
                    'Option 3' => 'option3',
                ]),
        ];
        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageField;
        }

        return $fields;
    }
}
