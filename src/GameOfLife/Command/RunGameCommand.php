<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Command {

    use GameOfLife\Representer\ArrayRepresenter;
    use GameOfLife\Seed\FileLoader;
    use GameOfLife\Transitioner\SimpleTransitioner;
    use GameOfLife\Universe\Universe;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Helper\Table;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;

    class RunGameCommand extends Command
    {
        const SLEEP_TIME = 500000;

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
                    'columns',
                    'c',
                    InputOption::VALUE_OPTIONAL,
                    'Width of the universe',
                    30
                )
                ->addOption(
                    'rows',
                    'r',
                    InputOption::VALUE_OPTIONAL,
                    'Height of the universe',
                    10
                )
                ->addArgument(
                    'seed',
                    InputArgument::REQUIRED,
                    'File with seed'
                )
            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $rows = $input->getOption('rows');
            $columns = $input->getOption('columns');
            $seedFile = $input->getArgument('seed');

            $seedLoader = new FileLoader();
            $seed = $seedLoader->load($seedFile);

            $universe = new Universe($rows, $columns, $seed, new SimpleTransitioner);

            $table = new Table($output);

            $representer = new ArrayRepresenter;
            $this->display($table, $universe, $representer, $output);
            usleep(self::SLEEP_TIME);

            while(true) {
                $universe->tick();
                $this->display($table, $universe, $representer, $output);

                usleep(self::SLEEP_TIME);
            }
        }

        private function display($table, $universe, $representer, $output)
        {
            $output->write(chr(27) . "[2J" . chr(27) . "[;H");

            $universeData = $representer->represent($universe);
            $table->setRows($universeData);
            $table->render();
        }
    }
}