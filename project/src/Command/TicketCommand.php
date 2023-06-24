<?php

// src/Command/TicketCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TicketCommand extends Command
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('ticket:create')
            ->setDescription('Create a new ticket');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $form = $this->formFactory->create(TicketFormType::class);
        $form->handleRequest();

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            // Faites quelque chose avec les données du ticket
            // ...

            $output->writeln('Ticket created successfully.');

            return Command::SUCCESS;
        }

        $output->writeln('Error creating the ticket.');

        return Command::FAILURE;
    }
}
