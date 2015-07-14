<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Universe {

    class Universe
    {
        const CELL_ALIVE = 1;
        const CELL_DEAD = 0;

        private $universe;

        public function __construct($width, $height, $seed)
        {
            $emptyUniverse = array_fill(0, $width, array_fill(0, $height, self::CELL_DEAD));
            $this->universe = array_merge_recursive($emptyUniverse, $seed);
        }

        private function neighbourCells($x, $y)
        {
            $result = [];
            for($wIndex=$x-1; $wIndex<=$x+1; $wIndex++)
            {
                for($hIndex=$y-1; $hIndex<=$y+1; $hIndex++)
                {
                    if($wIndex == $x && $hIndex == $y) {
                        continue;
                    }

                    $result[] = [$wIndex, $hIndex];
                }
            }

            return $result;
        }

        private function aliveCells($neighbours)
        {

            return array_filter($neighbours, function($cell) {
                list($x, $y) = $cell;

                return $this->universe[$x][$y] == self::CELL_ALIVE;
            });
        }

        private function transition($x, $y)
        {
            $neighbours = $this->neighbourCells($x, $y);
            $aliveNeighbours = $this->aliveCells($neighbours);

            switch(true) {
                case $this->cellWillComeToLife($aliveNeighbours):
                case $this->cellKeepsOnLiving($x, $y, $aliveNeighbours):
                    return self::CELL_ALIVE;
                    break;
                default:
                    return self::CELL_DEAD;
                    break;
            }
        }

        private function cellWillComeToLife($neighbours)
        {
            return count($neighbours) == 3;
        }

        private function cellKeepsOnLiving($x, $y, $neighbours)
        {
            return ($this->universe[$x][$y] == self::CELL_ALIVE && count($neighbours) == 2);
        }

        public function tick()
        {

        }
    }
}