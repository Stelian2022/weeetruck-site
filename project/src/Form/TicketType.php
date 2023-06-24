<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('category', ChoiceType::class, [
            'label' => '--Choisir votre problème--',
            'choices' => [
                'Option 1' => 'option1',
                'Option 2' => 'option2',
                'Option 3' => 'option3',
                'Autre' => 'autre',
            ],
            'constraints' => [
                new NotBlank(),
            ],
        ])
            ->add('email')
            ->add('titre')
            ->add('imageFilename', FileType::class, [
                'label' => 'Votre fichier',
                'required' => false,
            ])
            ->add('description');
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
 

     
}
