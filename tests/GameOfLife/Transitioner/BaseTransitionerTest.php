<?php

/**
 * Created by Evgeny Soynov <saboteur@saboteur.me> .
 */
class TestTransitioner extends \GameOfLife\Transitioner\BaseTransitioner {
    public function transition($row, $column) {}
    public function neighborCellsFor($row, $column)
    {
        return $this->neighbourCells($row, $column);
    }

    public function aliveCellsFor($neighbours)
    {
        return $this->aliveCells($neighbours);
    }
}

class BaseTransitionerTest extends \PHPUnit_Framework_TestCase
{
    private $universe;
    private $transitioner;

    public function __construct()
    {
        $seed = [
            [0,0,0,0],
            [0,0,1,0],
            [0,0,0,1],
            [0,1,1,1]
        ];
        $this->universe = $this
            ->getMockBuilder('\GameOfLife\Universe\Universe')
            ->setConstructorArgs([5, 5, $seed, new TestTransitioner])
            ->setMethods(null)
            ->getMock()
        ;

        $transitioner = new TestTransitioner;

        $transitioner->setUniverse($this->universe);

        $this->transitioner = $transitioner;
    }

    public function testCalculatesValidNeighborCells()
    {
        $neighbors = $this->transitioner->neighborCellsFor(0, 0);

        $validNeighbours = [
            [4,4], [4,0], [4,1],
            [0,4],        [0,1],
            [1,4], [1,0], [1,1],
        ];

        $this->assertEquals($validNeighbours, $neighbors);
    }

    public function testCalculatesValidAliveCells()
    {
        $neighbours = [];
        for($row = 1; $row <= 3; $row++) {
            for($column = 1; $column <= 3; $column++) {
                $neighbours[] = [$row, $column];
            }
        }

        $aliveNeighbours = $this->transitioner->aliveCellsFor($neighbours);
        $aliveNeighbours = array_values($aliveNeighbours);

        $validAlive = [
            [1,2], [2,3], [3,1], [3,2], [3,3]
        ];

        $this->assertEquals($validAlive, $aliveNeighbours);
    }
}