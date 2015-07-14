<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife {

    use GameOfLife\Command\RunGameCommand;
    use Symfony\Component\Console\Application as ConsoleApplication;
    use Symfony\Component\Console\Input\InputInterface;

    class Application extends ConsoleApplication
    {
        protected function getCommandName(InputInterface $input)
        {
            return 'gameoflife:run';
        }

        protected function getDefaultCommands()
        {
            $defaultCommands = parent::getDefaultCommands();

            $defaultCommands[] = new RunGameCommand();

            return $defaultCommands;
        }

        /**
         * Overridden so that the application doesn't expect the command
         * name to be the first argument.
         */
        public function getDefinition()
        {
            $inputDefinition = parent::getDefinition();
            $inputDefinition->setArguments();

            return $inputDefinition;
        }
    }
}