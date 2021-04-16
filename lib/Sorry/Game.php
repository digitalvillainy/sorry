<?php


namespace Sorry;

/**
 * Class to represent the whole game Sorry!
 */
class Game
{
    public function __construct($playing, $board) {
        $this->players = $playing;
        $this->currentTurn = 0;
        $this->board = $board;
        $this->cards = new Cards();
    }

    /**
     * Get the player whose turn it is to draw
     * @return int integer that represents the index players array of current player
     */
    public function getCurrentTurn()
    {
        return $this->currentTurn;
    }

    /**
     * @return cards of a total of 45 cards
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @return player players
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @return board of the game sorry
     */
    public function getBoard()
    {
        return $this->board;
    }

    public function newGame()
    {
        $this->board = new Board($this->players);
        $this->cards = new Cards();
        $this->currentTurn = 0;
    }

    /**
     * Function to handle functionality for turns
     * @param $og_pos The original position of the pawn the player clicked on to use their turn.
     * @param $move_dist How far the pawn should be moved.
     */
    public function doTurn($og_pos, $move_dist) {
        $squares = $this->board->getBoardSquares();
        // Get the node that was clicked on
        $node = $squares[$og_pos[0]][$og_pos[1]];
        //Functionality for starting a pawn (must draw a 1 or 2 to move from start)
        if ($this->board->isStartNode($node) && $move_dist != 1
        && $move_dist != 2) {
            return;
        }
        // Get the pawn in that node
        $pawn = $node->getCurrentPawn();
        // If there is no pawn, exit the function
        if ($pawn == null) {
            return;
        }
        
        // Get the player whose turn it is.
        $curPlayer = $this->players[$this->currentTurn];
        // If the current player is trying to move their own pawn
        if (strtolower($curPlayer->getColor()) == $pawn->getColor()) {
            // Move the pawn
            $turnResult = $this->board->movePawn($og_pos, $move_dist);
            // Go to the next player (loop back to player 1 if you reach the end)
            // if the movement was successful
            if ($turnResult && $move_dist != 2) {
                $this->incrementTurn();
            }
        }
    }

    public function incrementTurn() {
        $this->currentTurn += 1;
        if ($this->currentTurn >= count($this->players)) {
            $this->currentTurn = 0;
        }
    }

    public function draw() {
        $this->cards->drawCard();
    }


    /**
     * Function that handles which player wins the game.
     * If they are the winner, it means that all 4 of their pawns are in the home zone.
     * \return string that states the number of the winning player
     */
    public function theWinnerIs()
    {
        // If the winning player's home nodes are red
        if ($this->board->FindFullHomes() == "red")
        {
            // Should the private var below be called "player" instead of "players" if we are
            //trying to make calls to functions in the player class?
            // Get player 1's color
            //for now I will leave it as returning a string
            //return $this->player->getColor();
            return "red";
        }

        else if ($this->board->FindFullHomes() == "green")
        {
            // p1 is always red, p2 always green, p3 always blue, p4 always yellow, right?
            return "green";
        }

        else if ($this->board->FindFullHomes() == "blue")
        {
            return "blue";
        }

        else if ($this->board->FindFullHomes() == "yellow")
        {
            // p1 is always red, p2 always green, p3 always blue, p4 always yellow, right?
            return "yellow";
        }

        return "There is no winner yet.";
    }

    private $currentTurn;
    private $board;
    private $cards;
    private $players;
}