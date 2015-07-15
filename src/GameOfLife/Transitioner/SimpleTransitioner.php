<?php
/**
 * @author Evgeny Soynov <saboteur@saboteur.me>
 */

namespace GameOfLife\Transitioner {


    use GameOfLife\Cell\CellDefinition;

    class SimpleTransitioner extends BaseTransitioner
    {
        public function transition($row, $column)
        {
            $neighbours = $this->neighbourCells($row, $column);
            $aliveNeighbours = $this->aliveCells($neighbours);

            switch(true) {
                case $this->cellWillComeToLife($aliveNeighbours):
                case $this->cellKeepsOnLiving($row, $column, $aliveNeighbours):
                    return CellDefinition::CELL_ALIVE;
                    break;
                default:
                    return CellDefinition::CELL_DEAD;
                    break;
            }
        }
    }
}