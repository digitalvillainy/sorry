<?php

class GameTest extends \PHPUnit\Framework\TestCase
{
    public function test_construct()
    {
        $players = [new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        $this->assertInstanceOf('\Sorry\Game', $game);
        $this->assertEquals($board, $game->getBoard());
        $this->assertEquals($players, $game->getPlayers());
        $this->assertInstanceOf('\Sorry\Cards', $game->getCards());
        $this->assertEquals(0, $game->getCurrentTurn());
    }

    public function test_newGame()
    {
        // I thought it would be necessary to create the players
        // and board again so we could make a new game object, but
        // if my logic is wrong, please let me know.
        $players = [new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new Sorry\Board($players);
        // Bc of game constructor, the players in test class
        // are set to $this->players = $playing fr game class construct
        $game = new Sorry\Game($players, $board);

        $cards = new Sorry\Cards();
        // Make sure the currTurn is 0  since we are starting a
        // Game and no one has drawn a card yet
        $currTurn = $game->getCurrentTurn();
        $this->assertEquals(0, $currTurn);

        // Maybe instead this should be done like this?
        // if cards is an array then, we can't check it against an
        // int so we need the size of the cards array
        $this->assertInstanceOf('Sorry\Cards', $cards);

        // Check to make sure we have a new board for the game and it is not null
        $this->assertInstanceOf('Sorry\Board', $board);

        // Maybe should add if we have a new game with 2 or 3 players, but probably not necessary
    }

    public function test_doTurn()
    {
        $players = [new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        // Get the current player
        $player = $game->getPlayers()[$game->getCurrentTurn()];
        // node we will use to check if the pawn that was moved with
        // doTurn function is on the node it is supposed to be on
        $node = $node = new Sorry\Node("square");

        //$pawn = $node->getCurrentPawn();
        $squares = $board->GetBoardSquares();
        // A red pawn in a start corner
        $pawn = $squares[12][10]->getCurrentPawn();
        // assertNull for when trying to use doTurn on a node with no pawn on it
        $this->assertNull($game->doTurn([0, 0], 4));

        $redPlayer = $game->getPlayers()[$game->getCurrentTurn()];
        // redPawn is currently in start zone
        $redPawn = $squares[14][10]->getCurrentPawn();
        // test if player is trying to move its own pawn
        $this->assertEquals($pawn->getColor(), $player->getColor());
        $game->doTurn([14, 10], 2);
        // This is (hopefully) the location of $redPawn after doTurn is called on it
        $doTurnNode = $squares[15][10];
        // If these are =, it means that the $redPawn successfully moved 2 spaces and is
        // on the node it needs to be on
        $this->assertEquals($redPawn, $doTurnNode->getCurrentPawn());

        // You are a red player, but try to move blue's pawn
        // Verify that blue's pawn has not moved at all and
        // that currentTurn is the same number it was
        // before calling doTurn()
        $redPlayer = $game->getPlayers()[$game->getCurrentTurn()];
        // bluePawn is currently in start zone
        $bluePawn = $squares[10][3]->getCurrentPawn();
        // test if player is trying to move another player's pawn
        $this->assertNotEquals($bluePawn->getColor(), $redPlayer->getColor());

        $this->assertNull($game->doTurn([10, 3], 1));
        // Node [11][0] is 1 away from [10][3], so make sure [11][0] is empty and doesn't have a blue pawn on it.
        // If the 2 assertions below pass, the bluePawn did not make it to where it was supposed to
        // go when doTurn was called on it and it is still on the node that it started out on (a start zone node)
        $this->assertTrue($squares[11][0]->isEmpty());
        $this->assertFalse($squares[10][3]->isEmpty());

        // call do turn on red pawn in start zone 4 spaces ahead
        // check if node 3 spaces away from start is not empty and contains pawn that was just moved
        $pawnRed = $squares[12][12]->getCurrentPawn();
        $moveRedPawn = $game->doTurn([12, 12], 3);
        $redPawnNewLoc = $squares[15][10]->getCurrentPawn();

        // test if a player is trying to take two turns in a row
        // get the current player's turn using getCurrentTurn(), then
        //use doTurn function on that player, then after that call getCurrentTurn()
        // Again to see if getCurrentTurn still gives the same player
        // this is against the rules so it shouldn't be allowed

        // Test when a player who does not have the current turn tries to move one of their pawns
        $players = [new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        // Test when a player who does not have the current turn tries to move one of their pawns
        $redPlayer = $game->getPlayers()[$game->getCurrentTurn()];
        //print_r($redPlayer);
        //var_dump($game->getCurrentTurn());
        //var_dump($game->getCurrentTurn()+1);
        //print_r($game->getCurrentTurn());
        $greenPlayer = $game->getPlayers()[$game->getCurrentTurn()+1];
        $this->assertNotEquals($redPlayer, $greenPlayer);
        // We will try moving a green pawn out of start and onto the board, but it should
        // not work bc it is not green player's turn yet
        // trying to move the green pawn in bottom left corner of start zone, but it shouldn't work
        $this->assertNull($game->doTurn([5, 12], 1));
        // Make sure that square we attempted to move green pawn to is empty
        $this->assertTrue($squares[4][15]->isEmpty());
        // And that the green pawn is still where it started out before calling doTurn()
        $this->assertFalse($squares[5][12]->isEmpty());

        // Check that a player can do their turn again if they draw a 2 card
        // The distance they will move if they draw a 2 card is 2, it can't be 2 for
        // any other card in the deck
        $players = [new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        // Move a red pawn out of the start zone
        $redPawn = $squares[12][12]->getCurrentPawn();
        print_r($game->getPlayers()[$game->getCurrentTurn()]);
        // move a red out of start
        $this->assertNull($game->doTurn([12, 12], 1));
        // move a green out of start
        $this->assertNull($game->doTurn([3, 14], 1));
        // move a blue out of start
        $this->assertNull($game->doTurn([12, 1], 1));
        // move a yellow out of start
        $this->assertNull($game->doTurn([1, 3], 1));
        // Now it can be red's turn again
        $this->assertNull($game->doTurn([15, 11], 2));
        // Make sure that square we attempted to move red pawn from is empty
        $this->assertTrue($squares[15][11]->isEmpty());
        $doTurnNode = $squares[15][10];
        // If these are =, it means that the $redPawn successfully moved 2 spaces and is
        // on the node it needs to be on
        $this->assertEquals($redPawn, $doTurnNode->getCurrentPawn());
        // Since we draw a type 2 card (which means we draw again), we don't want the current turn to update
        // player array at idx 0 = the red player
        $this->assertEquals($game->getPlayers()[$game->getCurrentTurn()], $players[0]);
    }

    public function test_incrementTurn()
    {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer"),
            new \Sorry\Player("green", "greenPlayer")];
        $board = new Sorry\Board($players);
        $game = new Sorry\Game($players, $board);
        // Confirm that the blue player has the current turn
        $this->assertEquals($game->getPlayers()[$game->getCurrentTurn()], $players[0]);
        // Call incrementTurn() so we can move to next player, which should be red
        $game->incrementTurn();
        print_r($game->getPlayers()[$game->getCurrentTurn()]);
        $this->assertEquals($game->getPlayers()[$game->getCurrentTurn()], $players[1]);
        // incrementTurn() again to move to next player, which should be yellow
        $game->incrementTurn();
        $this->assertEquals($game->getPlayers()[$game->getCurrentTurn()], $players[2]);
        // incrementTurn() again to move to next player, which should be green
        $game->incrementTurn();
        $this->assertEquals($game->getPlayers()[$game->getCurrentTurn()], $players[3]);
        // incrementTurn() again to move to next player, which should start cycling through
        // all players again and be back to blue as the player w/ the current turn
        $game->incrementTurn();
        $this->assertEquals($game->getPlayers()[$game->getCurrentTurn()], $players[0]);
    }

    public function test_theWinnerIs()
    {
        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        // Testing for when there is no winner yet
        $this->assertNull($board->FindFullHomes());
        $this->assertEquals("There is no winner yet.", $game->theWinnerIs());
        // Move red pawns into their home zone
        $board->movePawn([12, 10], 65);
        $board->movePawn([12, 12], 65);
        $board->movePawn([14, 10], 65);
        $board->movePawn([14, 12], 65);
        $this->assertEquals("red", $board->FindFullHomes());
        // Confirm that the winner of the game was the red player
        $this->assertEquals("red", $game->theWinnerIs());

        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        // Move green pawns into their home zone
        $board->movePawn([5, 12], 65);
        $board->movePawn([3, 12], 65);
        $board->movePawn([3, 14], 65);
        $board->movePawn([5, 14], 65);
        $this->assertEquals("green", $board->FindFullHomes());
        // Confirm that the winner of the game was the green player
        $this->assertEquals("green", $game->theWinnerIs());

        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        // Move blue pawns into their home zone
        $board->movePawn([10, 3], 65);
        $board->movePawn([12, 3], 65);
        $board->movePawn([12, 1], 65);
        $board->movePawn([10, 1], 65);
        $this->assertEquals("blue", $board->FindFullHomes());
        // Confirm that the winner of the game was the blue player
        $this->assertEquals("blue", $game->theWinnerIs());

        $players = [new \Sorry\Player("blue", "bluePlayer"),
            new \Sorry\Player("red", "redPlayer"),
            new \Sorry\Player("green", "greenPlayer"),
            new \Sorry\Player("yellow", "yellowPlayer")];
        $board = new \Sorry\Board($players);
        $game = new \Sorry\Game($players, $board);
        // Move yellow pawns into their home zone
        $board->movePawn([3, 5], 65);
        $board->movePawn([3, 3], 65);
        $board->movePawn([1, 3], 65);
        $board->movePawn([1, 5], 65);
        $this->assertEquals("yellow", $board->FindFullHomes());
        // Confirm that the winner of the game was the yellow player
        $this->assertEquals("yellow", $game->theWinnerIs());
    }

}