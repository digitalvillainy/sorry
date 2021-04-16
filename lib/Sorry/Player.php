<?php


namespace Sorry;

//Current state of the game should be in the model class
    //ie how many active pawns a player has, how many of their pieces are at home
    // player= Bob, activePawns= num, color= green
class Player
{
    private $activePawns = [];      //Pawns currently on the board
    //Should this be an array or should we have a getter
    // for getting colors located somewhere else?
    private $color = '';
    //private $rowPos;
    //private $colPos;
    //Player name
    private $name;
    private $yourTurn;
    // Array for each player's 4 pawns
    private $pawns = array();

    /**
     * Constructor
     *
     * Build a player and assign its attributes
     * @param name
     * @param color
     */
    public function __construct($color, $name) {
        $this->color = $color;
        $this->name = $name;

        // Put the player's 4 pawns into the pawns array
        $this->pawns[] = new Pawn($this);
        $this->pawns[] = new Pawn($this);
        $this->pawns[] = new Pawn($this);
        $this->pawns[] = new Pawn($this);
    }

    /**
     * Get the player's color that they chose before the start of the game
     * @return The color of the player represented as a string
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Get name of the current player(s)
     * @return string name of the player
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get pawns that are playing on the board
     * @return array
     */
    public function getActive()
    {
        return $this->activePawns;
    }

    /**
     * @return array
     */
    public function getPawns(): array
    {
        return $this->pawns;
    }

    /**
     * Get the player whose currently up to draw a card
     * @return string name of the player
     */
    //these two should probably be game class logic
    //public function whoseTurn() {
      //  return $this->yourTurn;
    //}


    // Concerned with and only with the things the player is and will be
    //current position will be read by pawn class


    /*public function StartLocation($color)
    {
        //col, row
        if ($this->color == "Yellow") {
            array_push($this->activePawns, 4, 2);          //2 is row, 5 is col starting position of pawn
            array_push($this->activePawns, 5, 2);
            array_push($this->activePawns, 5, 3);
            array_push($this->activePawns, 6, 2);
        } else if ($this->color == "Red") {
            array_push($this->activePawns, 11, 15);          //2 is row, 5 is col starting position of pawn
            array_push($this->activePawns, 12, 15);
            array_push($this->activePawns, 13, 15);
            array_push($this->activePawns, 12, 14);

        } else if ($this->color == "Blue") {
            array_push($this->activePawns, 2, 11);          //2 is row, 5 is col starting position of pawn
            array_push($this->activePawns, 2, 12);
            array_push($this->activePawns, 2, 13);
            array_push($this->activePawns, 3, 12);

        }
        else if ($this->color == "Green") {
            array_push($this->activePawns, 15, 4);          //2 is row, 5 is col starting position of pawn
            array_push($this->activePawns, 15, 5);
            array_push($this->activePawns, 15, 6);
            array_push($this->activePawns, 14, 5);

        }
    }*/

    /*
     * if ($p1
     */
}