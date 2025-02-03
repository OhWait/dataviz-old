<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Maker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractMakeCommand extends Command
{
    public function __construct(
        protected KernelInterface $kernel,
    ) {
        parent::__construct();
    }

    /**
     * Demande à l'utilisateur de choisir une class parmis une liste correspondant au motif.
     *
     * @phpstan-ignore-next-line
     */
    protected function askClass(string $question, string $pattern, SymfonyStyle $io, bool $multiple = false): array
    {
        // On construit la liste utilisé pour l'autocompletion
        $classes = [];
        $paths = explode('/', $pattern);
        if (1 === count($paths)) {
            $directory = "{$this->kernel->getProjectDir()}/src";
        } else {
            $directory = "{$this->kernel->getProjectDir()}/src/".join('/', array_slice($paths, 0, -1));
            $pattern = join('/', array_slice($paths, -1));
        }
        $files = (new Finder())->in($directory)->name($pattern.'.php')->files();
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $filename = str_replace('.php', '', $file->getBasename());
            $classes[$filename] = $file->getPathname();
        }

        // On pose à l'utilisateur la question
        $q = new Question($question);
        $q->setAutocompleterValues(array_keys($classes));
        $answers = [];
        $replacements = [
            "{$this->kernel->getProjectDir()}/src" => 'App',
            '/' => '\\',
            '.php' => '',
        ];

        while (true) {
            $class = $io->askQuestion($q);
            if (null === $class) {
                return $answers;
            }
            $path = $classes[$class];

            $answers[] = [
                'namespace' => str_replace(array_keys($replacements), array_values($replacements), $path),
                'class_name' => $class,
            ];
            if (false === $multiple) {
                return $answers[0];
            }
        }
    }

    /**
     * Demande à l'utilisateur de choisir un domaine.
     */
    protected function askDomain(SymfonyStyle $io): string
    {
        // On construit la liste utilisé pour l'autocompletion
        $domains = [];
        $files = (new Finder())->in("{$this->kernel->getProjectDir()}/src")->depth(0)->directories();
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $domains[] = $file->getBasename();
        }

        // On pose à l'utilisateur la question
        $q = new Question('Sélectionner un domaine');
        $q->setAutocompleterValues($domains);

        return $io->askQuestion($q);
    }
}
