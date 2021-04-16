<?php


namespace Sorry;


class StartController
{
    private $game;                 // Object we are controlling (Sorry object/game object)
    //private $node;
    private $page = "game.php";     // Next page we will go to
    private $needAnother = false;         // If we don't have enough players and need to prompt user to add another player
    private $players = [];

    public function __construct($post)
    {
        //$this->game = $game;
        // Should we have a set players setter also?
        /*if (isset($post['player1']) && $post['player1'] != "")
        {
            // I think we are going to need something like addTo
                // function for the nodes for adding a player to
                // either the board or adding it to the game
            // we have addPlayer in the node class I see. Does it make sense
                // if I use it this way though?

            // Or maybe instead of hard coding red, yellow, green blue we should
                // have a SetColor() or ChooseColor() function???
            //$this->node->addPlayer($post['player1'], 'red');
        }

        if (isset($post['player2']) && $post['player2']!="") {
            $this->node->addPlayer($post['player1'], 'yellow');
        }
        if (count($this->game->getPlayers()) != 2) {
            // Then we don't have enough players for the game


        }
        if (isset($post['player3']) && $post['player3']!="") {
            $this->node->addPlayer($post['player1'], 'green');
        }
        //Would I have to add these for all the possible color choices for players?
            // I don't think so bc that would be a lot of code
        if (count($this->game->getPlayers()) == 2) {
            $this->needAnother = true;
        }
        else {
            // we can add a third player
            $this->node->addPLayer($post['player3'], 'blue');
        }
        if (isset($post['player4']) && $post['player4'] != "") {
            $this->node->addPlayer($post['player4'], 'green');
        }

        if($this->game->getPlayers() > 1 and $this->needAnother) {
            $this->page = 'game.php';
        } else {
            $this->page = 'index.php';
        }*/
        if (isset($post["red"])) {
            $player = new Player('red', "redPlayer");
            $this->players[] = $player;
        }
        if (isset($post["green"])) {
            $player = new Player('green', 'greenPlayer');
            $this->players[] = $player;
        }
        if (isset($post["blue"])) {
            $player = new Player('blue', 'bluePlayer');
            $this->players[] = $player;
        }
        if (isset($post["yellow"])) {
            $player = new Player('yellow', 'yellowPlayer');
            $this->players[] = $player;
        }
    }

    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPage()
    {
        return $this->page;
    }

    /* Functionality for winning a game and starting
     * a new game, which will eventually all be in game class
     *
     * public function gameWinner()
     * {
     *      $totalAtHome = 0;
     *      //get the player from the game class (getPLayers() getter)
     *      //players are in array, aren't they?
     *
     *      //get color of player from player class
     *
     *      // get the location of each of that player's pieces
     *      //maybe we should have a getter in the game class for the
     *      //type of location a pawn? Home, start board perimeter
     *      //maybe we will need to make an array for each player's pawns
     *      // or make a getPawns() getter in the game class
     *  //should there be an outer for loop to loop through each player as well?
     *      for ($i = 0; $i < (sizeof(pawnsArray[] ?); $i++)
 *          {
     *          //getPosition of pawn
     *          //check the locationType of the square it's on
     *              //if the location type is "home":
     *                  // increase total at home count
     *                  //$totalAtHome++;
     *                  //move to next pawn in array
     *                  if totalAtHome == 4:
     *                      //we have a winner
     *          NOTE: maybe this top function could go in player class,
     *          then we will call that function in a winner function in game
 *          }
     *  }
     * FUNCTIONS BELOW WILL BE IN GAME CLASS
*          public function Win()
*          {
*             $players = $this->getPlayers();
*             $gameWon = false;
*              $whoWon = 0;
*              for ($idx = 0; $idx < sizeof($players); $idx++)
*              {
*                 if ($player[$idx]->gameWinner())
*                 {
*                      $gameWon = true;
*                      $whoWon = $player[$idx];
*                 }
*              }
*              return $whoWon;
*          }
*
     *      this function will go in the game class I think
     *      private $startOver = false;
     *      public function newGame()
     *      {
     *          // we will need to clear pawns on current board
     *          // get the board again
     *          // get players
     *          // set the starting locations for players
     *          // the game class will take care of all things above
     *
     *          // call Win()
     *          //if Win() returns true:
     *              //$this->startover = true;
     *              // we will need to clear pawns on current board
     *          // Go back to game configuration page (the start page is what we are calling it I'm pretty sure)
     *      }
     *
     *
     */
}