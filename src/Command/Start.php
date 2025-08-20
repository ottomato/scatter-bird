<?php

namespace App\Command;

use App\Character\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class Start extends Command
{
    protected static $defaultName = 'app:start';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Starts the application')
            ->setHelp('This command allows you to start the application...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->clear();

        $helper = $this->getHelper('question');

        $characterCreation = true;

        While ($characterCreation === true) {
            $openQuestion = new Question('Character creations. What is the name of your character? ');
            $name = $helper->ask($input, $output, $openQuestion);
            if ($name) {
                $character = new Base();
                $character->setName($name);
                $output->writeln("Character created successfully.");
                $characterCreation = false;
            }
            $this->header($character->getName(), $output);
        }

        // Example dynamic room objects
        $roomObjects = ['lamp', 'book', 'key'];

        $loop = true;
        while ($loop === true) {
            $commands = ['show', 'exit'];

            foreach ($roomObjects as $object) {
                $commands[] = 'show ' . $object;
            }

            $question = new Question('Enter a command: ');
            $question->setAutocompleterValues($commands);

            $question->setValidator(function ($answer) use ($commands) {
                if (!in_array($answer, $commands)) {
                    throw new \RuntimeException('Invalid command.');
                }
                return $answer;
            });


            $answer = $helper->ask($input, $output, $question);

            if ($answer === 'exit') {
                $loop = false;
                $this->clear();
            }

            if ($answer === 'show') {
                $this->header($character->getName(), $output);
                $output->writeln("In the room you see: " . implode(', ', $roomObjects));
                $this->footer($output);
            }

            foreach ($roomObjects as $object) {
                if ($answer === 'show ' . $object) {
                    $this->header($character->getName(), $output);
                    $output->writeln("You see a $object in the room.");
                    $this->footer($output);
                }
            }
        }

        return Command::SUCCESS;
    }

    private function clear()
    {
        system('clear');
    }

    private function header(string $name, $output): void
    {
        $this->clear();
        $output->writeln('====================');
        $output->writeln('Character: ' . $name);
        $output->writeln('====================');
    }

    private function footer($output): void
    {
        $output->writeln("\n");
    }
}