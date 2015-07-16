<?php
/**
 * @author Evgeny Soynov <saboteur@saboteur.me>
 */

namespace GameOfLife\Transitioner {


    use GameOfLife\Cell\CellDefinition;

    abstract class BaseTransitioner implements TransitionerInterface
    {
        private $universe;

        public function setUniverse(\ArrayAccess $universe)
        {
            $this->universe = $universe;
        }

        abstract public function transition($row, $column);

        protected function neighbourCells($row, $column)
        {
            $result = [];
            $rowCount = count($this->universe);
            $columnCount = count($this->universe[0]);

            for ($rowIndex = $row - 1; $rowIndex <= $row + 1; $rowIndex++) {
                for ($columnIndex = $column - 1; $columnIndex <= $column + 1; $columnIndex++) {
                    if ($rowIndex == $row && $columnIndex == $column) {
                        continue;
                    }

                    $result[] = [
                        $this->ensureValidIndex($rowIndex, $rowCount),
                        $this->ensureValidIndex($columnIndex, $columnCount)
                    ];
                }
            }

            return $result;
        }

        protected function ensureValidIndex($index, $totalCount)
        {
            return $index > $totalCount-1 ?
                0
                : ($index < 0 ?
                    $totalCount-1
                    : $index)
            ;
        }

        protected function aliveCells($neighbours)
        {
            return array_filter($neighbours, function ($cell) {
                list($row, $column) = $cell;

                return $this->universe[$row][$column] == CellDefinition::CELL_ALIVE;
            });
        }

        protected function cellWillComeToLife($neighbours)
        {
            return count($neighbours) == 3;
        }

        protected function cellKeepsOnLiving($row, $column, $neighbours)
        {
            return ($this->universe[$row][$column] == CellDefinition::CELL_ALIVE && count($neighbours) == 2);
        }
    }
}