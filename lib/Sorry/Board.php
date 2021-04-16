<?php


namespace Sorry;

class Board {

    public function __construct($players) {
        $this->constructBoard($players);
    }

    private function constructBoard($players) {
        //Create both columns and rows
        for ($row = 0; $row < self::GRID_SIZE; $row++) {
            $curRow = [];
            for ($col = 0; $col < self::GRID_SIZE; $col++) {
                //Build first row
                if ($row == 0) {
                    $curCell = null;
                    if ($col == 1) {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("yellow", 3);
                    }
                    else if ($col == 9) {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("yellow", 4);
                    }
                    else {
                        $curCell = new Node("square");
                    }
                    if ($col != 0) {
                        $prevCell = $curRow[$col-1];
                        $prevCell->addTo($curCell);
                        $curCell->addTo($prevCell, "backwards");
                    }
                    $curRow[] = $curCell;
                }
                //Build Left column
                else if ($col == 0) {
                    $curCell = null;
                    if ($row == 14)  {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("blue", 3);
                    }
                    else if ($row == 6) {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("blue", 4);
                    }
                    else {
                        $curCell = new Node("square");
                    }
                    if ($row == 1) {
                        $nextCell = $this->mSquares[0][0];
                        $curCell->addTo($nextCell);
                        $nextCell->addTo($curCell, "backwards");
                    }
                    else {
                        $nextCell = $this->mSquares[$row-1][0];
                        $curCell->addTo($nextCell);
                        $nextCell->addTo($curCell, "backwards");
                    }
                    $curRow[] = $curCell;
                }
                //Build right column
                else if ($col == 15) {
                    $curCell = null;
                    if ($row == 1) {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("green", 3);
                    }
                    else if ($row == 9) {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("green", 4);
                    }
                    else {
                        $curCell = new Node("square");
                    }
                    if ($row == 1) {
                        $prevCell = $this->mSquares[0][15];
                        $prevCell->addTo($curCell);
                        $curCell->addTo($prevCell, "backwards");
                    }
                    else {
                        $prevCell = $this->mSquares[$row-1][15];
                        $prevCell->addTo($curCell);
                        $curCell->addTo($prevCell, "backwards");
                        //Handle the path into the green safe zone
                        if ($row == 2) {
                            $nextCell = $curRow[14];
                            $curCell->addTo($nextCell);
                            $nextCell->addTo($curCell, "backwards");
                        }
                        //Handle path from green start zone
                        /*else if ($row == 4) {
                            $prevCell = $curRow[14];
                            $prevCell->addTo($curCell);
                            $curCell->addTo($prevCell, "backwards");
                        }*/
                    }
                    //Set up the corner node
                    if ($row == 15) {
                        $nextCell = $curRow[14];
                        $curCell->addTo($nextCell);
                        $nextCell->addTo($curCell, "backwards");
                    }
                    $curRow[] = $curCell;
                }
                //Build bottom row
                else if ($row == 15) {
                    $curCell = null;
                    if ($col == 14) {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("red", 3);
                    }
                    else if ($col == 6) {
                        $curCell = new Node("slider");
                        $curCell->setSliderProperties("red", 4);
                    }
                    else {
                        $curCell = new Node("square");
                    }
                    if ($col == 1) {
                        $nextCell = $curRow[0];
                        $curCell->addTo($nextCell);
                        $nextCell->addTo($curCell, "backwards");
                    }
                    else {
                        $nextCell = $curRow[$col-1];
                        $curCell->addTo($nextCell);
                        $nextCell->addTo($curCell, "backwards");
                        //Handle path from red start zone
                        /*if ($col == 11) {
                            $prevCell = $this->mSquares[14][11];
                            $prevCell->addTo($curCell);
                            $curCell->addTo($prevCell, "backwards");
                        }*/
                        //Handle path into red safe zone
                        if ($col == 13) {
                            $nextCell = $this->mSquares[14][13];
                            $curCell->addTo($nextCell);
                            $nextCell->addTo($curCell, "backwards");
                        }
                    }
                    $curRow[] = $curCell;
                }
                //Red Start Zone
                else if ($row > 11 && $row < 15 && $col > 9 && $col < 13) {
                    $curCell = new Node("start", "red");
                    $curRow[] = $curCell;
                    $this->mPlayer1Start[] = $curCell;
                }
                //Red safe zone
                else if ($row > 9 && $row < 15 && $col == 13) {
                    $curCell = new Node("safe", "red");
                    $nextCell = $this->mSquares[$row-1][13];
                    $curCell->addTo($nextCell);
                    $nextCell->addTo($curCell, "backwards");
                    $curRow[] = $curCell;
                }
                //Red home zone
                else if ($row > 6 && $row < 10 && $col > 11 && $col < 15) {
                    $curCell = new Node("home", "red");
                    $curRow[] = $curCell;
                    $this->mPlayer1Home[] = $curCell;
                }
                //Green start zone
                else if ($col > 11 && $col < 15 && $row > 2 && $row < 6) {
                    $curCell = new Node("start", "green");
                    $curRow[] = $curCell;
                    $this->mPlayer2Start[] = $curCell;
                }
                //Green safe zone
                else if ($row == 2 && $col > 9 && $col < 15) {
                    $curCell = new Node("safe", "green");
                    $nextCell = $curRow[$col-1];
                    $curCell->addTo($nextCell);
                    $nextCell->addTo($curCell, "backwards");
                    $curRow[] = $curCell;
                }
                //Green home zone
                else if ($row > 0  && $row < 5 && $col > 6 && $col < 10) {
                    $curCell = new Node("home", "green");
                    $curRow[] = $curCell;
                    $this->mPlayer2Home[] = $curCell;
                }
                //Blue start zone
                else if ($col > 0 && $col < 4 && $row > 9 && $row < 13) {
                    $curCell = new Node("start", "blue");
                    /*if ($row == 11 && $col == 1) {
                        $nextCell = $curRow[0];
                        $curCell->addTo($nextCell);
                        $nextCell->addTo($curCell, "backwards");
                    }*/
                    $curRow[] = $curCell;
                    $this->mPlayer3Start[] = $curCell;
                }
                //Blue safe zone
                else if ($col > 0 && $col < 6 && $row == 13) {
                    $curCell = new Node("safe", "blue");
                    $prevCell = $curRow[$col-1];
                    $prevCell->addTo($curCell);
                    $curCell->addTo($prevCell, "backwards");
                    $curRow[] = $curCell;
                }
                //Blue home zone
                else if ($col > 5 && $col < 9 && $row > 11 && $row < 15) {
                    $curCell = new Node("home", "blue");
                    if ($row == 13 && $col == 6) {
                        $prevCell = $curRow[$col-1];
                        $prevCell->addTo($curCell);
                        $curCell->addTo($prevCell, "backwards");
                    }
                    $curRow[] = $curCell;
                    $this->mPlayer3Home[] = $curCell;
                }
                //Fill in the yellow start zone
                else if ($row > 0 && $row < 4 && $col > 2 && $col < 6) {
                    $curCell = new Node("start", "yellow");
                    /*if ($row == 1 && $col == 4) {
                        $nextCell = $this->mSquares[0][4];
                        $curCell->addTo($nextCell);
                        $nextCell->addTo($curCell, "backwards");
                    }*/
                    $curRow[] = $curCell;
                    //NOTE: You might need to track the indices rather than the node itself
                    $this->mPlayer4Start[] = $curCell;
                }
                //Fill in the yellow safe zone
                else if ($row > 0 && $row < 6 && $col == 2) {
                    $curCell = new Node("safe", "yellow");
                    if ($row == 1) {
                        $prevCell = $this->mSquares[0][2];
                        $prevCell->addTo($curCell);
                        $curCell->addTo($prevCell, "backwards");
                    }
                    else {
                        $prevCell = $this->mSquares[$row-1][2];
                        $prevCell->addTo($curCell);
                        $curCell->addTo($prevCell, "backwards");
                    }
                    $curRow[] = $curCell;
                }
                //Fill in the yellow home zone
                else if ($row > 5 && $row < 9 && $col > 0 && $col < 4) {
                    $curCell = new Node("home", "yellow");
                    if ($row == 6 && $col == 2) {
                        $prevCell = $this->mSquares[5][2];
                        $prevCell->addTo($curCell);
                        $curCell->addTo($prevCell, "backwards");
                    }
                    $curRow[] = $curCell;
                    $this->mPlayer4Home[] = $curCell;
                }
                //Fill the rest of the board with empty squares
                else {
                    $curCell = new Node("empty");
                    $curRow[] = $curCell;
                }
            }
            $this->mSquares[] = $curRow;
        }

        //Set up red path out of start zone
        $redExit = $this->mSquares[15][11];
        foreach ($this->mPlayer1Start as $startNode) {
            $startNode->addTo($redExit);
        }
        //Setup green path out of start zone
        $greenExit = $this->mSquares[4][15];
        foreach ($this->mPlayer2Start as $startNode) {
            $startNode->addTo($greenExit);
        }
        //Setup blue path out of start zone
        $blueExit = $this->mSquares[11][0];
        foreach ($this->mPlayer3Start as $startNode) {
            $startNode->addTo($blueExit);
        }
        //Setup yellow path out of start zone
        $yellowExit = $this->mSquares[0][4];
        foreach ($this->mPlayer4Start as $startNode) {
            $startNode->addTo($yellowExit);
        }

        foreach ($players as $player) {
            $color = $player->getColor();
            $playerPawns = $player->getPawns();
            /*$pawnOne = new Pawn($player);
            $pawnTwo = new Pawn($player);
            $pawnThree = new Pawn($player);
            $pawnFour = new Pawn($player);*/
            $pawnOne = $playerPawns[0];
            $pawnTwo = $playerPawns[1];
            $pawnThree = $playerPawns[2];
            $pawnFour = $playerPawns[3];
            if ($color == "red") {
                $this->mSquares[12][10]->addPawn($pawnOne);
                $this->mSquares[12][12]->addPawn($pawnTwo);
                $this->mSquares[14][10]->addPawn($pawnThree);
                $this->mSquares[14][12]->addPawn($pawnFour);
            }
            else if ($color == "green") {
                $this->mSquares[5][12]->addPawn($pawnOne);
                $this->mSquares[3][12]->addPawn($pawnTwo);
                $this->mSquares[5][14]->addPawn($pawnThree);
                $this->mSquares[3][14]->addPawn($pawnFour);
            }
            else if ($color == "blue")  {
                $this->mSquares[10][3]->addPawn($pawnOne);
                $this->mSquares[12][3]->addPawn($pawnTwo);
                $this->mSquares[10][1]->addPawn($pawnThree);
                $this->mSquares[12][1]->addPawn($pawnFour);
            }
            else if ($color == "yellow") {
                $this->mSquares[3][5]->addPawn($pawnOne);
                $this->mSquares[3][3]->addPawn($pawnTwo);
                $this->mSquares[1][5]->addPawn($pawnThree);
                $this->mSquares[1][3]->addPawn($pawnFour);
            }
        }
        //TESTING THINGY
        /*$testPlayer = new Player("red", "Billy");
        $testPawn = new Pawn($testPlayer);
        $this->mSquares[1][0]->addPawn($testPawn);*/
    }

    public function GetBoardSquares() {
        return $this->mSquares;
    }

    /**
     * Function to move a pawn forward/backward on the board
     * @param $og_pos array The current position of the pawn
     * @param $move_dist int How many spaces forward the pawn should move.
     */
    public function movePawn(array $og_pos, int $move_dist) {
        //Do nothing if distance is zero
        if ($move_dist == 0) {
            return false;
        }
        //Get the node the pawn is one
        $curNode = $this->mSquares[$og_pos[0]][$og_pos[1]];
        //Get the pawn on the node
        $pawn = $curNode->getCurrentPawn();
        //If we need to move backwards
        if ($move_dist < 0) {
            $curNode->backwardsSearchReachable(-1*$move_dist);
        }
        //If we need to move forward
        else {
            $curNode->searchReachable($move_dist, $pawn->getColor());
        }
        //This is the node we want to move to
        $distNode = $this->findReachableNode();
        if ($distNode === null) {
            return false;
        }
        //If there is a pawn on the node you are moving to.
        if ($distNode->isEmpty() == false) {
            //Move that other pawn back to its start zone
            $this->returnPawnToStart($distNode);
        }
        if($distNode->getType() == "slider"){
            if($distNode->getSliderColor() == $pawn->getColor()){
                $distNode->resetNodeValues();
                $distNode->searchReachable($distNode->getSliderLength(), $pawn->getColor());
                $distNode = $this->findReachableNode();

            }
        }
        //Assign the player to that new node
        $distNode->addPawn($pawn);
        //Remove the player from the old node
        $curNode->removePawn();
        //Unmark the node as reachable
        $distNode->resetNodeValues();
        if ($distNode->getType() == "home") {
            $this->goHomeCorners($distNode);
        }
        return true;
    }

    /**
     * Function to find a reachable node on the board
     * @return mixed The reachable node on the board
     */
    private function findReachableNode()
    {
        foreach ($this->mSquares as $row) {
            foreach ($row as $node) {
                if ($node->checkReachable()) {
                    return $node;
                }
            }
        }
        return null;
    }

    /**
     * Function to return a pawn on a given node back to start
     * @param $curNode Node The node the pawn needs to be moved off of
     */
    public function returnPawnToStart(Node $curNode) {
        //Get the pawn on the node
        $pawn = $curNode->getCurrentPawn();
        //Get the color of the pawn
        $color = $pawn->getColor();
        //Check the color and remove the pawn from the current node
        if ($color == "red") {
            $curNode->removePawn();
            //Find an empty red space and move it there
            if ($this->mSquares[12][10]->isEmpty()) {
                $this->mSquares[12][10]->addPawn($pawn);
            }
            else if ($this->mSquares[12][12]->isEmpty()) {
                $this->mSquares[12][12]->addPawn($pawn);
            }
            else if ($this->mSquares[14][10]->isEmpty()) {
                $this->mSquares[14][10]->addPawn($pawn);
            }
            else if ($this->mSquares[14][12]->isEmpty()) {
                $this->mSquares[14][12]->addPawn($pawn);
            }
        }
        else if ($color == "green") {
            $curNode->removePawn();
            //Find an empty green space and move it there
            if ($this->mSquares[5][12]->isEmpty()) {
                $this->mSquares[5][12]->addPawn($pawn);
            }
            else if ($this->mSquares[3][12]->isEmpty()) {
                $this->mSquares[3][12]->addPawn($pawn);
            }
            else if ($this->mSquares[3][14]->isEmpty()) {
                $this->mSquares[3][14]->addPawn($pawn);
            }
            else if ($this->mSquares[5][14]->isEmpty()) {
                $this->mSquares[5][14]->addPawn($pawn);
            }
        }
        else if ($color == "blue") {
            $curNode->removePawn();
            //Find an empty blue space and move it there.
            if ($this->mSquares[10][3]->isEmpty()) {
                $this->mSquares[10][3]->addPawn($pawn);
            }
            else if ($this->mSquares[12][3]->isEmpty()) {
                $this->mSquares[12][3]->addPawn($pawn);
            }
            else if ($this->mSquares[12][1]->isEmpty()) {
                $this->mSquares[12][1]->addPawn($pawn);
            }
            else if ($this->mSquares[10][1]->isEmpty()) {
                $this->mSquares[10][1]->addPawn($pawn);
            }
        }
        else if ($color == "yellow") {
            $curNode->removePawn();
            //Find an empty yellow space and move it there
            if ($this->mSquares[3][5]->isEmpty()) {
                $this->mSquares[3][5]->addPawn($pawn);
            }
            else if ($this->mSquares[3][3]->isEmpty()) {
                $this->mSquares[3][3]->addPawn($pawn);
            }
            else if ($this->mSquares[1][3]->isEmpty()) {
                $this->mSquares[1][3]->addPawn($pawn);
            }
            else if ($this->mSquares[1][5]->isEmpty()) {
                $this->mSquares[1][5]->addPawn($pawn);
            }
        }
        /*else {
            //Just some stuff for error checking.
            print_r("Pawn color " . $color . " is not a recognized color in Board.php");
        }*/
    }

    /**
     * Function to add a pawn to one of the four corners of the home zone after
     * it enters the home zone from the home zone entrance
     * @param Node $currNode The node the pawn needs to be moved off of (the entrance to the home zone)
     */
    private function goHomeCorners(Node $currNode)
    {
        // We have to make sure that the currNode is the entrance to the red home zone
        if ($currNode->getType() == "home") {
            // Get the pawn and see if it is on the current node
            $pawn = $currNode->getCurrentPawn();
            // Check pawn's color
            $color = $pawn->getColor();
            if ($color == "red") {
                // We will be checking the player1home array since that is for the red home zone
                $currNode->removePawn();
                // Check the top left corner of the home zone first
                if ($this->mSquares[7][12]->isEmpty()) {
                    $this->mSquares[7][12]->addPawn($pawn);
                } // Next we are checking the top right corner
                else if ($this->mSquares[7][14]->isEmpty()) {
                    $this->mSquares[7][14]->addPawn($pawn);
                } // Check the bottom left corner
                else if ($this->mSquares[9][12]->isEmpty()) {
                    $this->mSquares[9][12]->addPawn($pawn);
                } // Finally check the bottom right corner
                else if ($this->mSquares[9][14]->isEmpty()) {
                    $this->mSquares[9][14]->addPawn($pawn);
                }

            }

            if ($color == "green") {
                // We will be checking the player1home array since that is for the red home zone
                $currNode->removePawn();
                // Check the top left corner of the home zone first
                // This is the top left corner if we are looking at board straight on,
                // not if we turn it 180deg so green home is upright
                if ($this->mSquares[1][7]->isEmpty()) {
                    $this->mSquares[1][7]->addPawn($pawn);
                } // Next we are checking the top right corner
                else if ($this->mSquares[1][9]->isEmpty()) {
                    $this->mSquares[1][9]->addPawn($pawn);
                } // Check the bottom left corner
                else if ($this->mSquares[3][7]->isEmpty()) {
                    $this->mSquares[3][7]->addPawn($pawn);
                } // Finally check the bottom right corner
                else if ($this->mSquares[3][9]->isEmpty()) {
                    $this->mSquares[3][9]->addPawn($pawn);
                }

            }

            if ($color == "blue") {
                // We will be checking the player1home array since that is for the red home zone
                $currNode->removePawn();
                // Check the top left corner of the home zone first
                // This is the top left corner if we are looking at board straight on,
                // not if we turn it so blue home is upright
                if ($this->mSquares[12][6]->isEmpty()) {
                    $this->mSquares[12][6]->addPawn($pawn);
                } // Next we are checking the top right corner
                else if ($this->mSquares[12][8]->isEmpty()) {
                    $this->mSquares[12][8]->addPawn($pawn);
                } // Check the bottom left corner
                else if ($this->mSquares[14][6]->isEmpty()) {
                    $this->mSquares[14][6]->addPawn($pawn);
                } // Finally check the bottom right corner
                else if ($this->mSquares[14][8]->isEmpty()) {
                    $this->mSquares[14][8]->addPawn($pawn);
                }

            }

            if ($color == "yellow") {
                // We will be checking the player1home array since that is for the red home zone
                $currNode->removePawn();
                // Check the top left corner of the home zone first
                // This is the top left corner if we are looking at board straight on,
                // not if we turn it so yellow home is upright
                if ($this->mSquares[6][1]->isEmpty()) {
                    $this->mSquares[6][1]->addPawn($pawn);
                } // Next we are checking the top right corner
                else if ($this->mSquares[6][3]->isEmpty()) {
                    $this->mSquares[6][3]->addPawn($pawn);
                } // Check the bottom left corner
                else if ($this->mSquares[8][1]->isEmpty()) {
                    $this->mSquares[8][1]->addPawn($pawn);
                } // Finally check the bottom right corner
                else if ($this->mSquares[8][3]->isEmpty()) {
                    $this->mSquares[8][3]->addPawn($pawn);
                }
            }
        }
    }

    /**
     * Function that checks the home zones of each of the colors on the
     * board to see if any of their corners are completely filled.
     */
    public function FindFullHomes()
    {
        $p1HomeCnt= 0;
        $p2HomeCnt = 0;
        $p3HomeCnt = 0;
        $p4HomeCnt = 0;


        foreach ($this->mPlayer1Home as $square) {
            $pawn = $square->getCurrentPawn();
            if ($pawn != null) {
                $p1HomeCnt++;
            }
        }
        if ($p1HomeCnt === 4) {
            return "red";
        }
        foreach ($this->mPlayer2Home as $square) {
            $pawn = $square->getCurrentPawn();
            if ($pawn != null) {
                $p2HomeCnt++;
            }
        }
        if ($p2HomeCnt === 4) {
            return "green";
        }
        foreach ($this->mPlayer3Home as $square) {
            $pawn = $square->getCurrentPawn();
            if ($pawn != null) {
                $p3HomeCnt++;
            }
        }
        if ($p3HomeCnt === 4) {
            return "blue";
        }
        foreach ($this->mPlayer4Home as $square) {
            $pawn = $square->getCurrentPawn();
            if ($pawn != null) {
                $p4HomeCnt++;
            }
        }
        if ($p4HomeCnt === 4) {
            return "yellow";
        }

        return null;
    }

    public function isStartNode(Node $node) {
        if (in_array($node, $this->mPlayer1Start)) {
            return true;
        }
        if (in_array($node, $this->mPlayer2Start)) {
            return true;
        }
        if (in_array($node, $this->mPlayer3Start)) {
            return true;
        }
        if (in_array($node, $this->mPlayer4Start)) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getPlayer1StartNodes(): array
    {
        return $this->mPlayer1Start;
    }

    /**
     * @return array
     */
    public function getPlayer2StartNodes(): array
    {
        return $this->mPlayer2Start;
    }

    /**
     * @return array
     */
    public function getPlayer3StartNodes(): array
    {
        return $this->mPlayer3Start;
    }

    /**
     * @return array
     */
    public function getPlayer4StartNodes(): array
    {
        return $this->mPlayer4Start;
    }

    /*
     * use App\lib\Pawn;
// $this->setHomeGoal('red', '2,1');

// Will set the value of the home goal
// Pawns land here and will be moved with another function
public $homeGoals = [];
public $homeCorners = [];
function setHomeGoal($color, $position)
{
    $this->homeGoals[$color] = $position;
}

// $this->homeGoals= [ 'red'=> '4,5', 'blue'=> '2,1'];
//$this->homeCorners = [ 'red' => ['2,3' '3, 4' '4,6', '5,8']];

// will be called at pawn movement
function atHomeGoal($color, $position)
{
    // ask about player getName() function. Is it player
    if ($this->pawn->checkPosition(Pawn::getName())) {
        if (pawn->getColor() == node->getColor()) {
            //iterate over $this->homeGoals

            $results = array_search($pos, $this->homeGoals);
            if(!empty($results)){
                // Change Pawn Position.

            switch($results){
                case 'blue':
                // change pawn position to blue corner
                    break;
                case 'red':
                // change pawn position to blue corner
                    break;

                }
            }
        }
  }
}

function setPawnPosToCorner()
{
    // corners that the player has occupied / player score. Player hits 4 they win
    // maybe move playercorners out as a global var
    $playerCorners = [];
    foreach($homeCorners as $key, $value)
  {
      // corner !== occupied ? move pawn to corner : player wins
      //$key is the color of the corner node
      //the line below gives us the value, which is the x,y for some home corner for some color in $key
      $corner =  array_search($key, $homeCorners[$key])
    //check if node isEmpty
   		//move pawn to corner
      	// increment count for filled corners
      	//if count gets to 4:
      		//all corners filled
      		//now
  }
  // $playerCorners = ['red'=>3, 'blue'=>2];
  return game::state($playerCorners);
 }
// pawnName for example will be something like "red pawn 1" or something
//these would be declared in the pawn class
// $pawnName is the pawn that we are checking position and get back coordinates
// $this->pawn->checkPosition($pawnName);

use App\lib\PlayerModel;
$playerModel = New PlayerModel;
$playerInfo = PlayerModel::getPlayerInfo();
private $pawn;
private $node;
 */

    private $mSquares = [];
    //Red start squares
    private $mPlayer1Start = [];
    //Green start squares
    private $mPlayer2Start = [];
    //Blue start squares
    private $mPlayer3Start = [];
    //Yellow start squares
    private $mPlayer4Start = [];
    private $mPlayer1Home = [];
    private $mPlayer2Home = [];
    private $mPlayer3Home = [];
    private $mPlayer4Home = [];
    const GRID_SIZE = 16;
}