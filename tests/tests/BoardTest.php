<?php


class BoardTest extends \PHPUnit\Framework\TestCase
{
    public function test_construct() {
        $players = [new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new Sorry\Board($players);
        $this->assertInstanceOf('Sorry\Board', $board);
        $squares = $board->GetBoardSquares();
        //Make sure there are 16 rows
        $this->assertCount(16, $squares);
        //Make sure each row has 16 items
        for ($i = 0; $i < count($squares); $i++) {
            $this->assertCount(16, $squares[$i]);
            foreach ($squares[$i] as $node) {
                $this->assertInstanceOf('Sorry\Node', $node);
            }
        }

        //Check the connectivity of squares in the first and last row
        for($col = 0; $col < 16; $col++) {
            //Check the first row
            $curNode = $squares[0][$col];
            $nextNode = $this->getNeighborNode($curNode->getNeighbors());
            $prevNode = $this->getNeighborNode($curNode->getBackwardNeighbors());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);

            //Check the last row
            $curNode = $squares[15][$col];
            $nextNode = $this->getNeighborNode($curNode->getNeighbors());
            $prevNode = $this->getNeighborNode($curNode->getBackwardNeighbors());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);
        }

        //Check connectivity of squares in the left and right columns
        for ($row = 0; $row < 16; $row++) {
            //Check the first column
            $curNode = $squares[$row][0];
            $nextNode = $this->getNeighborNode($curNode->getNeighbors());
            $prevNode = $this->getNeighborNode($curNode->getBackwardNeighbors());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);

            //Check the last column
            $curNode = $squares[$row][15];
            $nextNode = $this->getNeighborNode($curNode->getNeighbors());
            $prevNode = $this->getNeighborNode($curNode->getBackwardNeighbors());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);
        }

        //Check connectivity of red safe/home
        for ($row = 10; $row < 15; $row++) {
            $curNode = $squares[$row][13];
            $nextNode = $squares[$row-1][13];
            $prevNode = $squares[$row+1][13];
            $this->assertEquals("red", $curNode->getColor());
            $this->assertEquals("safe", $curNode->getType());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);
        }

        //Check connectivity of Green safe/home
        for ($col = 10; $col < 15; $col++) {
            $curNode = $squares[2][$col];
            $nextNode = $squares[2][$col-1];
            $prevNode = $squares[2][$col+1];
            $this->assertEquals("green", $curNode->getColor());
            $this->assertEquals("safe", $curNode->getType());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);
        }

        //Check connectivity of blue safe/home
        for ($col = 1; $col < 6; $col++) {
            $curNode = $squares[13][$col];
            $prevNode = $squares[13][$col-1];
            $nextNode = $squares[13][$col+1];
            $this->assertEquals("blue", $curNode->getColor());
            $this->assertEquals("safe", $curNode->getType());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);
        }

        //Check connectivity of yellow safe/home
        for ($row = 1; $row < 6; $row++) {
            $curNode = $squares[$row][2];
            $nextNode = $squares[$row+1][2];
            $prevNode = $squares[$row-1][2];
            $this->assertEquals("yellow", $curNode->getColor());
            $this->assertEquals("safe", $curNode->getType());
            $this->assertNeighbors($curNode, $prevNode, $nextNode);
        }

        //Check sliders
        $shortYellow = $squares[0][1];
        $this->assertSlider($shortYellow, "yellow", 3);
        $longYellow = $squares[0][9];
        $this->assertSlider($longYellow, "yellow", 4);
        $shortGreen = $squares[1][15];
        $this->assertSlider($shortGreen, "green", 3);
        $longGreen = $squares[9][15];
        $this->assertSlider($longGreen, "green", 4);
        $shortRed = $squares[15][14];
        $this->assertSlider($shortRed, "red", 3);
        $longRed = $squares[15][6];
        $this->assertSlider($longRed, "red", 4);
        $shortBlue = $squares[14][0];
        $this->assertSlider($shortBlue, "blue", 3);
        $longBlue = $squares[6][0];
        $this->assertSlider($longBlue, "blue", 4);
        //Check start zones
        $redStartNodes = $board->getPlayer1StartNodes();
        $redExitNode = $squares[15][11];
        $this->assertStartNodes($redStartNodes, $redExitNode, "red");
        $greenStartNodes = $board->getPlayer2StartNodes();
        $greenExitNode = $squares[4][15];
        $this->assertStartNodes($greenStartNodes, $greenExitNode, "green");
        $blueStartNodes = $board->getPlayer3StartNodes();
        $blueExitNode = $squares[11][0];
        $this->assertStartNodes($blueStartNodes, $blueExitNode, "blue");
        $yellowStartNodes = $board->getPlayer4StartNodes();
        $yellowExitNode = $squares[0][4];
        $this->assertStartNodes($yellowStartNodes, $yellowExitNode, "yellow");
        //Check player spawns
        $this->assertPawnsInStart($squares, "red");
        $this->assertPawnsInStart($squares, "green");
        $this->assertPawnsInStart($squares, "blue");
        $this->assertPawnsInStart($squares, "yellow");

        //Check again to make sure the player creation works with less than 4
        $newPlayers = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer")];
        $newBoard = new \Sorry\Board($newPlayers);
        $this->assertPawnsInStart($newBoard->GetBoardSquares(), "blue");
        $this->assertPawnsInStart($newBoard->GetBoardSquares(), "red");
    }

    public function test_GetBoardSquares() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer")];
        $board = new \Sorry\Board($players);
        $squares = $board->GetBoardSquares();
        $this->assertNotNull($squares);
        //Should contain 16 rows.
        $this->assertCount(16, $squares);
    }

    public function test_movePawn() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer")];
        $board = new \Sorry\Board($players);
        $board->movePawn([14, 12], 3);
        $squares = $board->GetBoardSquares();
        $prevNode = $squares[14][12];
        $this->assertNull($prevNode->getCurrentPawn());
        $movedNode = $squares[15][9];
        $pawn = $movedNode->getCurrentPawn();
        $this->assertNotNull($pawn);
        $this->assertInstanceOf("Sorry\Pawn", $pawn);
        //Test no distance
        $board->movePawn([15, 9], 0);
        $movedNode = $squares[15][9];
        $pawn = $movedNode->getCurrentPawn();
        $this->assertInstanceOf("Sorry\Pawn", $pawn);
        //Test backwards movement (negative distance)
        $board->movePawn([15, 9], -7);
        $prevNode = $squares[15][9];
        $this->assertNull($prevNode->getCurrentPawn());
        $moveNode = $squares[14][15];
        $pawn = $moveNode->getCurrentPawn();
        $this->assertNotNull($pawn);
        $this->assertInstanceOf("Sorry\Pawn", $pawn);

        //Now we must test that going to the home corners works correctly
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $squares = $board->GetBoardSquares();
        //Move red pawns on to home zone.
        $board->movePawn([12, 10], 65);
        $board->movePawn([12, 12], 65);
        $board->movePawn([14, 10], 65);
        $board->movePawn([14, 12], 65);
        //Make sure the four corners of the red home zone are filled
        $this->assertEquals("red", $squares[7][12]->getCurrentPawn()->getColor());
        $this->assertEquals("red", $squares[7][14]->getCurrentPawn()->getColor());
        $this->assertEquals("red", $squares[9][12]->getCurrentPawn()->getColor());
        $this->assertEquals("red", $squares[9][14]->getCurrentPawn()->getColor());

        //Move blue pawns to their home
        $board->movePawn([10, 3], 65);
        $board->movePawn([12, 3], 65);
        $board->movePawn([12, 1], 65);
        $board->movePawn([10, 1], 65);
        //Make sure the four corners of the blue home zone are filled
        $this->assertEquals("blue", $squares[12][8]->getCurrentPawn()->getColor());
        $this->assertEquals("blue", $squares[14][8]->getCurrentPawn()->getColor());
        $this->assertEquals("blue", $squares[12][6]->getCurrentPawn()->getColor());
        $this->assertEquals("blue", $squares[14][6]->getCurrentPawn()->getColor());

        //Move green pawns to their home
        $board->movePawn([5, 12], 65);
        $board->movePawn([3, 12], 65);
        $board->movePawn([3, 14], 65);
        $board->movePawn([5, 14], 65);
        //Make sure the four corners of the blue home zone are filled
        $this->assertEquals("green", $squares[3][7]->getCurrentPawn()->getColor());
        $this->assertEquals("green", $squares[1][7]->getCurrentPawn()->getColor());
        $this->assertEquals("green", $squares[3][9]->getCurrentPawn()->getColor());
        $this->assertEquals("green", $squares[1][9]->getCurrentPawn()->getColor());

        //Move the yellow pawns to their home
        $board->movePawn([3, 5], 65);
        $board->movePawn([3, 3], 65);
        $board->movePawn([1, 3], 65);
        $board->movePawn([1, 5], 65);
        //Make sure the four corners of the blue home zone are filled
        $this->assertEquals("yellow", $squares[8][3]->getCurrentPawn()->getColor());
        $this->assertEquals("yellow", $squares[8][1]->getCurrentPawn()->getColor());
        $this->assertEquals("yellow", $squares[6][3]->getCurrentPawn()->getColor());
        $this->assertEquals("yellow", $squares[6][1]->getCurrentPawn()->getColor());

        //Test sliders
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        //Move red pawn on to slider.
        $board->movePawn([12, 10], 6);
        $endSquare = $squares[15][2];
        //Make sure the pawn has ended up at the end of the slider
        $pawn = $endSquare->getCurrentPawn();
        $this->assertNotNull($pawn, "Slider functionality broken.");

        //Move that red pawn over to the blue slider now
        $board->movePawn([15, 2], 13);

        //Move blue pawn to the slider
        $board->movePawn([10, 3], 6);
        //Make sure the red pawn on the slider gets sent back to its start
        $this->assertPawnsInStart($squares, "red");

        //See if blue will slide past its home zone.
        $board->movePawn([12, 3], 58);
        $endSquare = $squares[11][0];
        //Make sure the pawn ended up at the end of the slider
        $pawn = $endSquare->getCurrentPawn();
        $this->assertNotNull($pawn);
    }

    public function test_returnPawnToStart() {
        //Send Blues back to start (test by moving onto)
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $squares = $board->GetBoardSquares();
        $board->movePawn([10, 3], 1);
        $board->movePawn([12, 3], 2);
        $board->movePawn([12, 1], 3);
        $board->movePawn([10, 1], 4);
        //Verify the blue start zone is now empty
        $this->assertNull($squares[10][3]->getCurrentPawn());
        $this->assertNull($squares[12][3]->getCurrentPawn());
        $this->assertNull($squares[12][1]->getCurrentPawn());
        $this->assertNull($squares[10][1]->getCurrentPawn());
        //Move red pawns on top of blue pawns
        $board->movePawn([12, 10], 16);
        $board->movePawn([12, 12], 17);
        $board->movePawn([14, 10], 18);
        $board->movePawn([14, 12], 19);
        //Verify that the blue pawns are back in the start
        $this->assertPawnsInStart($squares, "blue");

        //Verify the red start is empty
        $this->assertNull($squares[12][10]->getCurrentPawn());
        $this->assertNull($squares[12][12]->getCurrentPawn());
        $this->assertNull($squares[14][10]->getCurrentPawn());
        $this->assertNull($squares[14][12]->getCurrentPawn());
        //I should then be able to send each red pawn back
        //directly by using the function
        $board->returnPawnToStart($squares[11][0]);
        $board->returnPawnToStart($squares[10][0]);
        $board->returnPawnToStart($squares[9][0]);
        $board->returnPawnToStart($squares[8][0]);
        $this->assertPawnsInStart($squares, "red");

        //Send Greens back
        $board->movePawn([5, 12], 1);
        $board->movePawn([3, 12], 2);
        $board->movePawn([3, 14], 3);
        $board->movePawn([5, 14], 4);
        //Verify the green start is empty
        $this->assertNull($squares[5][12]->getCurrentPawn());
        $this->assertNull($squares[3][12]->getCurrentPawn());
        $this->assertNull($squares[3][14]->getCurrentPawn());
        $this->assertNull($squares[5][14]->getCurrentPawn());
        //return them to the start now
        $board->returnPawnToStart($squares[4][15]);
        $board->returnPawnToStart($squares[5][15]);
        $board->returnPawnToStart($squares[6][15]);
        $board->returnPawnToStart($squares[7][15]);
        $this->assertPawnsInStart($squares, "green");

        //Send yellows back
        $board->movePawn([3, 5], 1);
        $board->movePawn([3, 3], 2);
        $board->movePawn([1, 3], 3);
        $board->movePawn([1, 5], 4);
        //Verify the yellow start is empty
        $this->assertNull($squares[3][5]->getCurrentPawn());
        $this->assertNull($squares[3][3]->getCurrentPawn());
        $this->assertNull($squares[1][3]->getCurrentPawn());
        $this->assertNull($squares[1][5]->getCurrentPawn());
        //return the yellows to the start now
        $board->returnPawnToStart($squares[0][4]);
        $board->returnPawnToStart($squares[0][5]);
        $board->returnPawnToStart($squares[0][6]);
        $board->returnPawnToStart($squares[0][7]);
        $this->assertPawnsInStart($squares, "yellow");
    }

    public function test_FindFullHomes() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $this->assertNull($board->FindFullHomes());
        //Move red pawns on to home zone.
        $board->movePawn([12, 10], 65);
        $board->movePawn([12, 12], 65);
        $board->movePawn([14, 10], 65);
        $board->movePawn([14, 12], 65);
        $this->assertEquals("red", $board->FindFullHomes());

        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        //Move green pawns to their home
        $board->movePawn([5, 12], 65);
        $board->movePawn([3, 12], 65);
        $board->movePawn([3, 14], 65);
        $board->movePawn([5, 14], 65);
        $this->assertEquals("green", $board->FindFullHomes());

        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        //Move blue pawns to their home
        $board->movePawn([10, 3], 65);
        $board->movePawn([12, 3], 65);
        $board->movePawn([12, 1], 65);
        $board->movePawn([10, 1], 65);
        $this->assertEquals("blue", $board->FindFullHomes());

        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        //Move the yellow pawns to their home
        $board->movePawn([3, 5], 65);
        $board->movePawn([3, 3], 65);
        $board->movePawn([1, 3], 65);
        $board->movePawn([1, 5], 65);
        $this->assertEquals("yellow", $board->FindFullHomes());
    }

    public function test_getPlayer1StartNodes() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $nodes = $board->getPlayer1StartNodes();
        $this->assertCount(9, $nodes);
    }

    public function test_getPlayer2StartNodes() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $nodes = $board->getPlayer2StartNodes();
        $this->assertCount(9, $nodes);
    }

    public function test_getPlayer3StartNodes() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $nodes = $board->getPlayer3StartNodes();
        $this->assertCount(9, $nodes);
    }

    public function test_getPlayer4StartNodes() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $nodes = $board->getPlayer4StartNodes();
        $this->assertCount(9, $nodes);
    }

    public function test_isStartNode() {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $squares = $board->GetBoardSquares();
        //Make sure it works for each start zone
        $this->assertTrue($board->isStartNode($squares[12][10]));
        $this->assertTrue($board->isStartNode($squares[5][12]));
        $this->assertTrue($board->isStartNode($squares[10][3]));
        $this->assertTrue($board->isStartNode($squares[3][5]));
        //Make sure it returns false for non-start nodes
        $this->assertFalse($board->isStartNode($squares[0][0]));
    }

    /*
     * This function is used to get a non safe zone neighbor node
     */
    private function getNeighborNode($neighbors) {
        foreach ($neighbors as $to) {
            if ($to->getColor() == "None" || $to->getType() == "slider") {
                return $to;
            }
        }
        return null;
    }

    /*
     * Function to make sure the connections between neighbors go both ways
     */
    private function assertNeighbors($curNode, $prevNode, $nextNode) {
        //Make sure there is no weird looping going on
        $this->assertNotEquals($curNode, $prevNode);
        $this->assertNotEquals($curNode, $nextNode);
        $this->assertNotEquals($prevNode, $nextNode);
        //Make sure the node before and the current node are linked correctly
        $this->assertContains($curNode, $prevNode->getNeighbors(), "prev does not lead to cur");
        $this->assertContains($prevNode, $curNode->getBackwardNeighbors(), "cur does not lead to prev");
        //Make sure the current node and the node after are linked correctly
        $this->assertContains($curNode, $nextNode->getBackwardNeighbors(), "next does not come from cur");
        $this->assertContains($nextNode, $curNode->getNeighbors(), "cur does not lead to next");
    }

    private function assertSlider($sliderNode, $color, $length) {
        $this->assertEquals("slider", $sliderNode->getType());
        $this->assertEquals($color, $sliderNode->getSliderColor());
        $this->assertEquals($length, $sliderNode->getSliderLength());
    }

    private function assertStartNodes($startNodes, $exitNode, $color) {
        //There are 9 start nodes for each color
        $this->assertCount(9, $startNodes);
        //Assert the properties and connections of each start node
        foreach ($startNodes as $node) {
            $this->assertEquals($color, $node->getColor());
            $this->assertEquals("start", $node->getType());
            $this->assertNotEmpty($node->getNeighbors());
            $toNode = $node->getNeighbors()[0];
            $this->assertEquals($exitNode, $toNode);
        }
    }

    private function assertPawnsInStart($squares, $color) {
        $corners = [];
        if ($color == "red") {
            $corners[] = $squares[12][10];
            $corners[] = $squares[14][10];
            $corners[] = $squares[12][12];
            $corners[] = $squares[14][12];
        }
        else if ($color == "green") {
            $corners[] = $squares[3][12];
            $corners[] = $squares[3][14];
            $corners[] = $squares[5][12];
            $corners[] = $squares[5][14];
        }
        else if ($color == "blue") {
            $corners[] = $squares[10][1];
            $corners[] = $squares[10][3];
            $corners[] = $squares[12][1];
            $corners[] = $squares[12][3];
        }
        else if ($color == "yellow") {
            $corners[] = $squares[1][3];
            $corners[] = $squares[1][5];
            $corners[] = $squares[3][3];
            $corners[] = $squares[3][5];
        }
        foreach ($corners as $node) {
            $pawn = $node->getCurrentPawn();
            $this->assertInstanceOf('Sorry\Pawn', $pawn);
            $this->assertEquals($color, $pawn->getColor());
        }
    }
}