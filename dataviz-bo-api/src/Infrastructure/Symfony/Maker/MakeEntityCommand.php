<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Maker;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:entity')]
class MakeEntityCommand extends AbstractMakeCommand
{
    protected function configure(): void
    {
        $this
            ->setDescription('Crée une entité dans le domaine choisi et le test associé')
            ->addArgument('entityName', InputArgument::OPTIONAL, "Nom de l'entité");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $domain = $this->askDomain($io);
        $entity = $this->askEntity($io);

        $application = $this->getApplication();
        $command = $application->find('make:entity');

        $greetInput = new ArrayInput([
            'command' => 'make:entity',
            'name' => "\\App\\Domain\\Model\\$entity",
        ]);
        /*
        $greetInput = new ArrayInput([
            'command' => 'make:entity',
            'name' => "\\App\\$domain\\Model\\$entity",
        ]);
        */

        return $command->run($greetInput, $output);
    }

    /**
     * Demande à l'utilisateur de choisir un nom d'entité.
     */
    private function askEntity(SymfonyStyle $io): string
    {
        // On pose à l'utilisateur la question
        $q = new Question('Nom de l\'entité');

        return $io->askQuestion($q);
    }
}
