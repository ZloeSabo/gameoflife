<?php
/**
 * @author Evgeny Soynov <saboteur@saboteur.me>
 */

namespace GameOfLife\Transitioner {

    interface TransitionerInterface
    {
        public function setUniverse(\ArrayAccess $universe);

        public function transition($row, $column);
    }
}