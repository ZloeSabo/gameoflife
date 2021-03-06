<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Universe {

    use GameOfLife\Cell\CellDefinition;
    use GameOfLife\Transitioner\TransitionerInterface;

    class Universe implements \ArrayAccess, \Countable, \Iterator
    {
        private $universe;
        private $transitioner;
        private $position = 0;

        public function __construct($rows, $columns, $seed, TransitionerInterface $transitioner)
        {
            $emptyUniverse = array_fill(0, $rows, array_fill(0, $columns, CellDefinition::CELL_DEAD));
            $this->universe = array_replace_recursive($emptyUniverse, $seed);

            $this->transitioner = $transitioner;
        }

        public function tick()
        {
            $this->transitioner->setUniverse($this);

            $newUniverse = [];
            foreach($this->universe as $row => $columns) {
                foreach($columns as $column => $cell) {
                    $newUniverse[$row][$column] = $this->transitioner->transition($row, $column);
                }
            }

            $this->universe = $newUniverse;
        }

        public function offsetSet($offset, $value)
        {
            if (is_null($offset)) {
                $this->universe[] = $value;
            } else {
                $this->universe[$offset] = $value;
            }
        }

        public function offsetExists($offset)
        {
            return isset($this->universe[$offset]);
        }

        public function offsetUnset($offset)
        {
            unset($this->universe[$offset]);
        }

        public function offsetGet($offset)
        {
            return isset($this->universe[$offset]) ? $this->universe[$offset] : null;
        }

        public function count()
        {
            return count($this->universe);
        }

        function rewind() {
            $this->position = 0;
        }

        function current() {
            return $this->universe[$this->position];
        }

        function key() {
            return $this->position;
        }

        function next() {
            ++$this->position;
        }

        function valid() {
            return isset($this->universe[$this->position]);
        }
    }
}