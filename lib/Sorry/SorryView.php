<?php



namespace Sorry;



class SorryView
{
    //private $cards;
    private $card;
    private $game;  // The Sorry! game object
    //public $html;   // Final html output
    //public $row;    // Row html

    /**
     * Constructor
     * @param Game $game The Sorry! game object
     */
    public function __construct($game)
    {
        $this->game = $game;
    }

        // change to string, add to string each time and return a string that contains all
        //html that makes the board
        //make css divs for cells in the board

        //generate divs in view.php using loops
        //set background for all cells using the sorryboard picture using css

    /**
     * Convert CSS from sorry.css to strings for drawing the cells on the game board
     * @param $rowNum number of rows in the game board (will go up to 16 because 16 rows total)
     * @return string HTML
     */
    public function createCells($rowNum = 1) //$row as other param
    {

        //$html = <<<HTML
        //$row = '<div class="row">';
        //$this->html = '<div class="row">';
//HTML;

        $html =<<<HTML
<div class="row">
HTML;

        // Instead of cells 0-15 and rows 0-15, we have cells 1-16 and rows 1-16
        // Will indicate value for each cell's button
        // Value for button will be (row number, cell number in that row)
        // Rows 1-16, cells per row are also 1-16
        for ($cellNum = 1; $cellNum < 17; $cellNum++) {
            //$cell = '<div class="cell"><button value="' . $rowNum . ',' . $cellNum . '" ></div>';
            $html .= '<div class="cell"><button value="' . $rowNum . ',' . $cellNum . '" ></div>';
            //$row . $cell;

        }
        $html .= '</div>';
        //$row . '</div>';

        return $html;
    }

    /**
     * Generate and return the HTMl for our playing board
     * @return string HTML
     */
    public function presentBoard()
    {
        $html=<<<HTML
<div class="board">
<figure><img src="sorryboard.png" width="2048" height="2048" alt=""/></figure>
HTML;

        // add all 16 rows with 16 cells per row
        for ($i = 1; $i < 17; $i++) {
            $html .= $this->createCells($i);
        }

        // add closing tag to div class=board
        $html .= '</div>';
        return $html;
    }


    /**
     * Draw all 16 rows on the game board that contain the 16 cells per row
     */
//    public function createRow()
//    {
//        //$board = $this->game->getBoard();
//        //$html = '';
//        //$board = '<div class="board">';
//        for ($i = 1; $i < 17; $i++) {
//            //$row = $this->createCells($i);
//            //$board . $row;
//            //$this->row .= $this->createCells($i);
//            $this->createCells($i);
//        }
//        //$board . '</div>';
//
//        //return $this->row;
//    }

//    /**
//     *
//     * Calling createRow() function and concatenating the results in the $board.
//     * @return string HTML
//     */
//    public function setBoard()
//    {
//        $board = '<div class="board">';
//        $board .= $this->createRow();
//        // Here we are also returning the results of concatenation.
//        $board .= '</div>';
//
//        return $board;
//    }

//    /**
//     * @return string
//     */
//    public function presentBoard()
//    {
//        return '<div class="board">
//          <figure><img src="sorryboard.png" width="2048" height="2048" alt=""/></figure>
//        </div>';
//    }


 /**
 * Finally the outputHtml. This will finally allow us to have 16 sets of 16 rows.
 * @return string
 */
 /*   public function outputHtml()
    {
        $this->html = '<form action="SorryController.php" method="post" class="game">';
        for ($i = 0; $i < 17; $i++) {
            $this->html .= $this->setBoard();
        }
        $this->html .= '</form>';
        return $this->html;
    }*/

    /** Display the board on the game.php page
     * @return string
     */
    public function displayBoard()
    {
        $htmlBoard = '<div class="board">';
        $board = $this->game->getBoard();
        $squares = $board->GetBoardSquares();
        for($row = 0; $row < 16; $row++)
        {
             $htmlBoard .= '<div class="row">';
             //for i in mSquares
                //for j in i

                    //check whether cell contains a pawn
             for ($col = 0; $col < 16; ++$col) {
                 $htmlBoard .= '<div class="cell">';
                 $pawn = $squares[$row][$col]->getCurrentPawn();
                 if ($pawn != null) {
                     $htmlBoard .= $this->drawPawns($pawn->getColor(), $row, $col, 1);
                     //$htmlBoard .= "<input type='submit' name='pawn' value='$row,$col,1'>";
                 }
                 $htmlBoard .= '</div>';
             }
             $htmlBoard .= '</div>';
        }
        return $htmlBoard;
    }


    /**
     * Display the four different types of pawns on the Sorry! game board
     * @param $color string Color of the pawn, can be red, blue, yellow or green
     * @return string HTML
     */
    public function drawPawns($color, $row, $col, $dist)
    {
        // Should I use getColor() from pawn class instead of this?
        // $color = $this->pawn->getColor()

//        $playerOne = player->color;  (player->color here represents color that player chose to use before starting game)
//	    Pawn::createPawn($playerOne);
        //$html = '';
        $html =<<<HTML

HTML;


        if ($color == "yellow")
        {
            $html .= "<button type='submit' name='pawn' value='$row,$col,$dist'><img src='yellow.png' alt='yellowPawn' class='pawn' width='192' height='192'></button>";
            //$html .= "<input type='image' src='yellow.png' alt='yellowPawn' name='pawn' width='52.8' height='52.8' value='$row,$col,$dist'>";
        }
        else if ($color == "blue")
        {
            $html .= "<button type='submit' name='pawn' value='$row,$col,$dist'><img src='blue.png' alt='bluePawn' class='pawn' width='192' height='192'></button>";
            //$html .= "<input type='image' src='blue.png' alt='bluePawn' name='pawn' width='52.8' height='52.8' value='$row,$col,$dist'>";
        }

        else if ($color == "green")
        {
            $html .= "<button type='submit' name='pawn' value='$row,$col,$dist'><img src='green.png' alt='greenPawn' class='pawn' width='192' height='192'></button>";
            //$html .= "<input type='image' src='green.png' alt='greenPawn' name='pawn' width='52.8' height='52.8' value='$row,$col,$dist'>";
        }

        else if ($color = "red")
        {
            $html .= "<button type='submit' name='pawn' value='$row,$col,$dist'><img src='red.png' alt='redPawn' class='pawn' width='192' height='192'></button>";
            //$html .= "<input type='image' src='red.png' alt='redPawn' name='pawn' width='52.8' height='52.8' value='$row,$col,$dist'>";
        }
        else
        {
            $html .= "<input type='submit' name='pawn' value='$row,$col,$dist'>";
        }

        return $html;
    }

    public function displayCurrentTurn() {
        $html = "<p class='turnText'>Current Turn: ";
        $turnIndex = $this->game->getCurrentTurn();
        $curPlayer = $this->game->getPlayers()[$turnIndex];
        $html .= $curPlayer->getColor();
        $html .= "</p>";
        return $html;
    }

    public function displayCards()
    {
        //$html = '';
        $html=<<<HTML

HTML;

        //$html .= '<img src="card_back.png" style="position:fixed; right:0px; bottom:0px; width:100px; height:100px; border:none;" alt="back of a sorry card"/>';

        //$html .= '<button> type='submit' value="card" <img src="card_back.png" style="position:relative; left:325px; top:-690px; width:178px; height:240px; border:none;" alt="back of a sorry card"/></button>';

        $html .= "<button class='cardButton' type='submit' name='card' value='card'> <img src='card_back.png' class='cardImg' width='192' height='256' alt='back of a sorry card'/></button>";

        // Get the assigned card value (the value the user sees)
        // which card should we display?
        //$whichCard = $this->card->getValue();
        //$whichCard = $this->game->getCards()->getCurrentCardValue();

        $whichCard = $this->game->getCards()->getCurrentCardValue();
        //$whichCard = Cards::ONE_CARD;
        // added above code for now... game->getCards does not work bc it is never set in the game class
        // will need to figure out a way to do this

        // if no card yet


        if ($whichCard == Cards::ONE_CARD)
        {
            // Not sure if the syntax above is correct
            //get rid of input tags
            //css testing maybe needs to be done
            //get the css to place the card on top of the board
            //try doing abs positioning for the html for the cards to get them to di
            //$html .= '<p><input class="card1" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_1.png" width="192" height="192" alt="card 1"/></figure>';
            //$html .= '<img src="card_1.png" style="position:relative; left:500px; top:-690px; width:178px; height:230px; border:none;" alt="card 1"/>';
            $html .= '<img src="card_1.png" class="drawnCard" width="256" height="192" alt="card 1"/>';
        }
        else if ($whichCard == Cards::TWO_CARD)
        {
            // Not sure if the syntax above is correct
            //$html .= '<p><input class="card2" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_2.png" width="192" height="192" alt="card 2"/></figure>';
            //$html .= '<img src="card_2.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 2"/>';
            $html .= '<img src="card_2.png" class="drawnCard" width="256" height="192" alt="card 2"/>';
        }
        else if ($whichCard == Cards::THREE_CARD)
        {
            // Not sure if the syntax above is correct
            //$html .= '<p><input class="card3" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_3.png" width="192" height="192" alt="card 3"/></figure>';
            //$html .= '<img src="card_3.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 3"/>';
            $html .= '<img src="card_3.png" class="drawnCard" width="256" height="192" alt="card 3"/>';
        }
        else if ($whichCard == Cards::FOUR_CARD)
        {
            // Not sure if the syntax above is correct
            //$html .= '<p><input class="card4" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_4.png" width="192" height="192" alt="card 4"/></figure>';
            //$html .= '<img src="card_4.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 4"/>';
            $html .= '<img src="card_4.png" class="drawnCard" width="256" height="192" alt="card 4"/>';
        }
        else if ($whichCard == Cards::FIVE_CARD)
        {
            //$html .= '<p><input class="card5" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_5.png" width="192" height="192" alt="card 5"/></figure>';
            //$html .= '<img src="card_5.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 5"/>';
            $html .= '<img src="card_5.png" class="drawnCard" width="256" height="192" alt="card 5"/>';
        }
        // Anybody know why there is no card 6?
        else if ($whichCard == Cards::SEVEN_CARD)
        {
            //$html .= '<p><input class="card7" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_7.png" width="192" height="192" alt="card 7"/></figure>';
            //$html .= '<img src="card_7.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 7"/>';
            $html .= '<img src="card_7.png" class="drawnCard" width="256" height="192" alt="card 7"/>';
        }
        else if ($whichCard == Cards::EIGHT_CARD)
        {
            //$html .= '<p><input class="card8" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_8.png" width="192" height="192" alt="card 8"/></figure>';
            //$html .= '<img src="card_8.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 8"/>';
            $html .= '<img src="card_8.png" class="drawnCard" width="256" height="192" alt="card 8"/>';
        }
        else if ($whichCard == Cards::TEN_CARD)
        {
            // Not sure if the syntax above is correct
            //$html .= '<p><input class="card10" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_10.png" width="192" height="192" alt="card 10"/></figure>';
            //$html .= '<img src="card_10.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 10"/>';
            $html .= '<img src="card_10.png" class="drawnCard" width="256" height="192" alt="card 10"/>';
        }
        else if ($whichCard == Cards::ELEVEN_CARD)
        {
            // Not sure if the syntax above is correct
            //$html .= '<p><input class="card11" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_11.png" width="192" height="192" alt="card 11"/></figure>';
            //$html .= '<img src="card_11.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 11"/>';
            $html .= '<img src="card_11.png" class="drawnCard" width="256" height="192" alt="card 11"/>';
        }
        else if ($whichCard == Cards::TWELVE_CARD)
        {
            // Not sure if the syntax above is correct
            //$html .= '<p><input class="card12" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_12.png" width="192" height="192" alt="card 12"/></figure>';
            //$html .= '<img src="card_12.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card 12"/>';
            $html .= '<img src="card_12.png" class="drawnCard" width="256" height="192" alt="card 12"/>';
        }
        else if ($whichCard == Cards::SORRY_CARD)
        {
            // Not sure if the syntax above is correct
            //$html .= '<p><input class="sorrycard" type="submit" name="display"></p>';
            //$html .= '<figure><img src="card_sorry.png" width="192" height="192" alt="card sorry"/></figure>';
            //$html .= '<img src="card_sorry.png" style="position:fixed; left:0px; top:0px; width:100px; height:100px; border:none;" alt="card sorry"/>';
            $html .= '<img src="card_sorry.png" class="drawnCard" width="256" height="192" alt="card sorry"/>';
        }
        return $html;
    }

    /** This function uses HTML to display a message that states the name of the
     * player who won the game. It uses the return value of TheWinnerIs() to check
     * the color of the player who has all their pawns in the home zone.
     * @return string
     */
    public function displayWinner()
    {
        // For testing purposes
        // We don't have a winner but this is important to see what the message looks
        // like with the CSS in sorry.css I added in
        if ($this->game->theWinnerIs() == "There is no winner yet.")
        {
            /*$winner = "No one";
            $html = '<div class="winner">';
            $html .= '<p>The winner is ';
            $html .= $winner;
            $html .= '! Congratulations.</p>';
            $html .= '</div>';
            return $html;*/
            return "";
        }
        // We need the players array bc we will be
        // outputting the name of the player that won in html
        else
        {     // access the players array in the StartController
            $html = '<p class="winnerText">The winner is ';
            $winnerStr = $this->game->theWinnerIs();
            $html .= "$winnerStr!</p>";
            return $html;
        }
        return $html;
    }

}
// once this is working we will call the functions for creating the board, cells and rows
// the functions from the view class will be called in the game.php inside the div.game class

//associate each player's pawn with a number so user knows which pawns they are playing with
//last checkmark should be the last cell of that row
//each box for the node will be checked if there is already a pawn in it
