<?php
/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */

namespace GameOfLife\Seed {

    interface SeedLoaderInterface
    {
        public function load($subject);
    }
}