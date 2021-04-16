<?php


namespace Sorry;

/**
 * A class to represent the player piece in the game sorry
 */
class Pawn
{
    /**
     * Constructor
     * @param Player $player
     * @
     */
    public function __construct($player) {
        //$this->color = $color;
        //$this->color = $player->getColor();
        $this->player = $player;
        $this->color = $player->getColor();
    }



    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }


    public function getPlayer(){
        return $this->player;
    }



    /**
     * Is this card safe
     * @return bool True if safe otherwise False
     */
    public function isSafe() {
        return $this->safe;
    }

    private $player;
    private $color;
    private $safe = false;
}