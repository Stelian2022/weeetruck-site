<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom (obligatoire)'],
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom (obligatoire)'],
                'required' => true,
            ])
          
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'E-mail (obligatoire)'],
                'required' => true,
            ])
            
            ->add('message', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => ['placeholder' => 'Votre commentaire ici...'],
                'required' => true,
            ]) ;
            // ->add('remember', CheckboxType::class, [
            //     'label' => 'Enregistrer mon nom, mon e-mail et mon site dans le navigateur pour mon prochain commentaire.',
            //     'required' => false,
            // ])
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
