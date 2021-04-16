<?php


class PawnTest extends \PHPUnit\Framework\TestCase
{
    public function test_construct()
    {
        $player1 = new Sorry\Player("red", "player 1");
        $pawn1 = new Sorry\Pawn($player1);
        $this->assertInstanceOf('Sorry\pawn', $pawn1);
        $player2 = new Sorry\Player("green", "player 2");
        $pawn2 = new Sorry\Pawn($player2);
        $this->assertInstanceOf('Sorry\pawn', $pawn2);
        $player3 = new Sorry\Player("blue", "player 3");
        $pawn = new Sorry\Pawn($player3);
        $this->assertInstanceOf('Sorry\pawn', $pawn);
        $player4 = new Sorry\Player("yellow", "player 4");
        $pawn4 = new Sorry\Pawn($player4);
        $this->assertInstanceOf('Sorry\pawn', $pawn4);
    }
}