<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Command {

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;

    class RunGameCommand extends Command
    {
        protected function configure()
        {
            $this
                ->setName('gameoflife:run')
                ->setDescription('Run game of life')
                ->addOption(
                    'iterations',
                    'i',
                    InputOption::VALUE_OPTIONAL,
                    'Number of iterations to run'
                )
                ->addOption(
                    'width',
                    'w',
                    InputOption::VALUE_OPTIONAL,
                    'Width of the universe',
                    200
                )
                ->addOption(
                    'height',
                    'h',
                    InputOption::VALUE_OPTIONAL,
                    'Height of the universe',
                    100
                )
            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output->writeln('works');
        }
    }
}