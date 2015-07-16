<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Representer {

    interface RepresenterInterface
    {
        public function represent(\ArrayAccess $data);
    }
}