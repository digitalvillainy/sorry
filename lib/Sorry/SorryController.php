<?php


namespace Sorry;



class SorryController
{
    private $node;
    private $player;
    private $pawn;
    private $game;                 // Object we are controlling
    private $page = "game.php";     // Next page we will go to
    private $reset = false;         // True if we need to reset the game

    public function __construct(Game $game, $post)
    {
        $this->game = $game;

        if (isset($post['playerTurn']))
        {
            $this->game->incrementTurn();

        }

        if (isset($post['clear']))
        {
            // We are starting a new game
            $this->game->newGame();
        }
        else if (isset($post['c'])) {
            // We are in cheat mode
            // Need to check if we actually need a cheat mode
            // Though, I forgot

        }

        // if player is drawing a card
        else if (isset($post['draw']))
        {
            //case Cards::TWO_CARD:
                //drawCardAgain
            //Check if user flipped the card over (maybe by using getter)
            //Move the card to the "Discard here" area, or check if it's in discard pile
            //Next person's turn (but do we need a getter for this?
                //Or is the getter for that getCurrentTurn() in game class?


        }
        //I think that before the player clicks on a node to move their pawn to
        //There is a lot of logic that has to be taken care of
        else if (isset($post['pawn']))
        {
            $xy_string = explode(',', $post['pawn']);


            $x = (int)$xy_string[0];
            $y = (int)$xy_string[1];
            print_r("HELLO?");
            //print_r($game->getBoard()->GetBoardSquares()[13][2]->getBackwardNeighbors());
            //$distance = 5;
            $distance = $this->game->getCards()->getCurrentCardValue();

            // 4 card moves backwards 4 spaces
            if ($distance == 4) {
                $distance = $distance * -1;
            }

            $this->game->doTurn([$x, $y], $distance);
            //This is where we find out which pawn the player will
                //choose to move if they have >1 pawn on the board currently

            //Looks to me like you can only split your moves between 2 pawns
                //if you draw a 7 card

            //I have this for now, but this getter will likely be moved from
            //player class to either board or game class
            //$this->player->getActive();

            //More than 1 active pawn on board? Pick one to move first
            // User should select the pawn they want to move
            //Make setter for setting the piece that player will move
        }

        //Checking if user has clicked on a node to move their pawn to
        else if (isset($post['click']))
        {
            //find the current position of the pawn the player wants to move
            $this->pawn->getPosition();

            // card 4, card 10 can move backwards
            // Other "backwards" one are "move the pawn back to start location", which I think is different

            // get value of card drawn by player that will move
            $this->card->getValue();

            //if the card is a card_4 or card_10, call backwardsSearchReachable
            $this->node->backwardsSearchReachable();
            // if it's any other type of card, just search reachable
            $this->node->searchReachable();
//click on the pawn
            //and move the pawn however many spaces the card tells it to
            //if you click on empty node, it does nothing
            //click on a pawn and it should move one space forward
            //it should happen regardless of whose turn it is


        }

        else if (isset($post['card'])) {
            $this->game->draw();
        }



    }


    public function getPage()
    {
        return $this->page;
    }

    //What are we going to do for handling new games?
    public function isReset()
    {
        return $this->reset;
    }

    /**
     * Move request
     * @param int $ndx Index for room to move to
     */
    private function MovePawn($ndx)
    {
        //check if the square is occupied
        //check if you are at the edge of the

        //check the current status of the pawn
        //type of the square the player's pawn is on (slide, start, etc)
        //if in a corner you will need to know which direction to go next
        //check current status of all player's pawns (how many at home,
            //how many at start, how many on the board


        // Other actions the player will need to do:
            // Turn card over after drawing and reading card
            // Place card in 'discard here' pile
    }

//array for which player's pawn is where will be here in the controller
// array for white space around perimeter
//array for home spaces
//array for start spaces

//when determining player's turn:
//if player has > 1 outside of start,
//pawn player will move
//subtract num of spaces a player moved pawn from the card move instructions
// if result of this > 0, you can move the same pawn or another pawn currently
// on the board the remaining amount of spaces
}