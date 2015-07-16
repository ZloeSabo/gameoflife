<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Representer {


    use GameOfLife\Cell\CellDefinition;

    class ArrayRepresenter implements RepresenterInterface
    {
        public function represent(\ArrayAccess $data)
        {
            $result = [];

            foreach($data as $row => $columns) {
                foreach($columns as $column => $cell) {
                    $result[$row][$column] = $cell == CellDefinition::CELL_DEAD ? ' ' : 'X';
                }
            }

            return $result;
        }
    }

}