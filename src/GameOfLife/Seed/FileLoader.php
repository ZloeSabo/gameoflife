<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Seed {

    use GameOfLife\Cell\CellDefinition;

    class FileLoader
    {
        public function load($subject)
        {
            $result = [];

            $data = file($subject);
            foreach($data as $row => $dataAsString) {
                $columns = str_split($dataAsString);
                $result[] = array_map(function($item) {
                    return $item == 'x' ?
                        CellDefinition::CELL_ALIVE
                        : CellDefinition::CELL_DEAD
                    ;
                }, $columns);
            }

            return $result;
        }
    }
}