<?php


class PlayerTest extends \PHPUnit\Framework\TestCase
{
    public function test_construct()
    {
        $player = new Sorry\Player('red', 'redPlayer');
        $this->assertInstanceOf('Sorry\Player', $player);
        $this->assertEquals('redPlayer', $player->getName());
        $this->assertEquals('red', $player->getColor());
        $player = new Sorry\Player('green', 'greenPlayer');
        $this->assertEquals('greenPlayer', $player->getName());
        $this->assertEquals('green', $player->getColor());
        $player = new Sorry\Player('blue', 'bluePlayer');
        $this->assertEquals('bluePlayer', $player->getName());
        $this->assertEquals('blue', $player->getColor());
        $player = new Sorry\Player('yellow', 'yellowPlayer');
        $this->assertEquals('yellowPlayer', $player->getName());
        $this->assertEquals('yellow', $player->getColor());
    }
}