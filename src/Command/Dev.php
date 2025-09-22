<?php

namespace App\Command;

use App\Character\Base;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use App\World\WorldBuilder;

class Dev extends Command
{
    protected static $defaultName = 'app:dev';

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Starts the application')
            ->setHelp('This command allows you to start the application...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $worldBuilder = new WorldBuilder();
        $world = $worldBuilder->build('Nescio');
        $locations = $worldBuilder->locations;
        $currentLocation = $locations['bedroom'];

        $exit = false;
        while ($exit === false) {
            $output->writeln('You are in: ' . $currentLocation->name);

            $question = new Question('Enter a command: ');
            $answer = $helper->ask($input, $output, $question);

            if ($answer === 'look') {
                $output->writeln('You see ' . $currentLocation->owner->name . "'s " . $currentLocation->description);
            }

            if ($answer === 'move') {
                $question = new ChoiceQuestion(
                    'Where do you want to go?',
                    $currentLocation->accessWays,
                    0
                );
                $destination = $helper->ask($input, $output, $question);

                $currentLocation = $locations[$destination];
            }

            if ($answer === 'exit') {
                $exit = true;
            }
        }

        return Command::SUCCESS;
    }
}