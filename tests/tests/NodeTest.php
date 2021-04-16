<?php


class NodeTest extends \PHPUnit\Framework\TestCase{
    public function test_constructor(){
        $node = new Sorry\Node("square");
        $this->assertInstanceOf('Sorry\Node', $node);
        $node2 = new Sorry\Node("empty");
        $this->assertEquals($node2->getType(), "empty");
        $node2 = new Sorry\Node("safe", "blue");
        $this->assertEquals($node2->getType(), "safe");

    }
    public function test_connections(){
        //test forward neighbors
        $node = new Sorry\Node("square");
        $forward_neighbor = new Sorry\Node("square");
        $node->addTo($forward_neighbor);
        $neighbors = $node->getNeighbors();
        $this->assertEquals($neighbors[0], $forward_neighbor);

        //test backwards neighbors
        $backwards_neighbor = new Sorry\Node("square");
        $node->addTo($backwards_neighbor, "backwards");
        $behindNeighbors = $node->getBackwardNeighbors();
        $this->assertEquals($behindNeighbors[0], $backwards_neighbor);

    }
    public function testSearchReachable(){
        $node = new Sorry\Node("square");
        $neighbor1 = new Sorry\Node("square");
        $neighbor2 = new Sorry\Node("square");
        $neighbor3 = new Sorry\Node("square");

        $node->addTo($neighbor1);
        $neighbor1->addTo($neighbor2);
        $neighbor2->addTo($neighbor3);
        //nodes on the path returns true if reachable
        //when distance is 1, then neighbor 1 is reachable
        // but neighbor 2 is not
        $node->searchReachable(1, "red");
        $this->assertTrue($neighbor1->checkReachable());
        $this->assertFalse($neighbor2->checkReachable());
        $neighbor1->resetNodeValues();

        //when distance is 2, neighbor 2 is the reachable node
        //but neighbors 1 and 3 are not reachable
        $node->searchReachable(2, "blue");
        $this->assertFalse($neighbor1->checkReachable());
        $this->assertTrue($neighbor2->checkReachable());
        $this->assertFalse($neighbor3->checkReachable());
        $this->assertEquals($neighbor1->getType(), "square");
        $this->assertEquals($neighbor2->getType(), "square");
        $this->assertEquals($neighbor3->getType(), "square");
        $neighbor2->resetNodeValues();

        //testing path forking with safe zone nodes

        $node2 = new Sorry\Node("safe", "blue");
        $neighbor3->addTo($node2);
        $neighbors = $neighbor3->getNeighbors();
        $this->assertEquals($neighbors[0], $node2);
        $neighbor3->searchReachable(1,"blue" );
        $this->assertTrue($node2->checkReachable());
        $node2->resetNodeValues();
        //pawn color doesnt match safe zone color
        $neighbor3->searchReachable(1,"red" );
        $this->assertFalse($node2->checkReachable());

        //testing pathforking with two neighbors - one neighbor is a safe
        //zone node of the same color and one neighbor is a normal square node
        //it marks the safe zone node as reachable since the pawn color and
        //safe zone color match
        $newnode = new Sorry\Node("square");
        $newneighbor1 = new Sorry\Node("square");
        $safeneighbor = new Sorry\Node("safe", "blue");
        $newnode->addTo($safeneighbor);
        $newnode->addTo($newneighbor1);
        $newnode->searchReachable(1, "blue");
        $this->assertFalse($newneighbor1->checkReachable());
        $this->assertTrue($safeneighbor->checkReachable());
        $safeneighbor->resetNodeValues();


        //test if can get to safe zone neighbors
        $safeneighbor2 = new Sorry\Node("safe", "blue");
        $safeneighbor->addTo($safeneighbor2);
        $newnode->searchReachable(2, "blue");
        $this->assertFalse($safeneighbor->checkReachable());
        $this->assertFalse($newneighbor1->checkReachable());
        $this->assertTrue($safeneighbor2->checkReachable());
        $safeneighbor2->resetNodeValues();


        //test if wrong colors go to second(non safe zone) neighbor
        $newnode->searchReachable(1, "red");
        $this->assertFalse($safeneighbor->checkReachable());
        $this->assertTrue($newneighbor1->checkReachable());

        //testing all pathforking functionality with different order of neighbors
        $newnode1 = new Sorry\Node("square");
        $newneighbor2 = new Sorry\Node("square");
        $safeneighbor1 = new Sorry\Node("safe", "blue");
        //adding square neighbor as first neighbor
        $newnode1->addTo($newneighbor2);
        $newnode1->addTo($safeneighbor1);
        $newnode1->searchReachable(1, "blue");
        $this->assertFalse($newneighbor2->checkReachable());
        $this->assertTrue($safeneighbor1->checkReachable());
        $safeneighbor1->resetNodeValues();

        //test if wrong colors go to second(non safe zone) neighbor
        $newnode1->searchReachable(1, "red");
        $this->assertFalse($safeneighbor1->checkReachable());
        $this->assertTrue($newneighbor2->checkReachable());


    }
    
    public function testBackwardsReachable(){
        //same logic as previous test only with backwards movement
        $node = new Sorry\Node("square");
        $neighbor1 = new Sorry\Node("square");
        $neighbor2 = new Sorry\Node("square");
        $neighbor3 = new Sorry\Node("square");
        $node->addTo($neighbor1,"backwards");
        $neighbor1->addTo($neighbor2,"backwards");
        $neighbor2->addTo($neighbor3,"backwards");
        //nodes on the path returns true if reachable
        //when distance is 1, then neighbor 1 is reachable
        // but neighbor 2 is not
        $node->backwardsSearchReachable(1);
        $this->assertTrue($neighbor1->checkReachable());
        $this->assertFalse($neighbor2->checkReachable());
        //when distance is 2, neighbors 1 and 2 are reachable
        //neighbor 3 is not reachable
        $node->backwardsSearchReachable(2);
        $this->assertTrue($neighbor1->checkReachable());
        $this->assertTrue($neighbor2->checkReachable());
        $this->assertFalse($neighbor3->checkReachable());


    }
    public function testSlider(){
        $slidernode = new Sorry\Node("slider");
        $slidernode->setSliderProperties("red", 5);
        $this->assertEquals("red",$slidernode->getSliderColor() );
        $this->assertEquals(5, $slidernode->getSliderLength());

    }
    public function testTaken(){
        //test to make sure taken nodes are marked as reachable so they can be
        // pushed back to start
        $node1 = new Sorry\Node("square");
        $node2 = new Sorry\Node("square");
        $node3 = new Sorry\Node("square");
        $node1->addTo($node2);
        $node2->addTo($node3);
        $player1 = new Sorry\Player("red", "player 1");
        $player1Pawn = new Sorry\Pawn($player1);
        $player2 = new Sorry\Player("blue", "player 2");
        $player2Pawn = new Sorry\Pawn($player2);
        $node1->addPawn($player1Pawn);
        $node3->addPawn($player2Pawn);
        $node1->searchReachable(2, $player1Pawn->getColor());
        $this->assertTrue($node3->checkReachable());
        $node3->resetNodeValues();

    }
    public function testNeighboring(){
        //make sure neighboring nodes with pawns are counted in the distance
        $node1 = new Sorry\Node("square");
        $node2 = new Sorry\Node("square");
        $node3 = new Sorry\Node("square");
        $node1->addTo($node2);
        $node2->addTo($node3);
        $player1 = new Sorry\Player("red", "player 1");
        $player1Pawn1 = new Sorry\Pawn($player1);
        $player1Pawn2 = new Sorry\Pawn($player1);
        $node1->addPawn($player1Pawn1);
        $node2->addPawn($player1Pawn2);
        $node1->searchReachable(2, $player1Pawn1->getColor());
        $this->assertTrue($node3->checkReachable());
        $node3->resetNodeValues();


    }

    public function testHome(){
        //test that the home node is marked reachable
        $node1 = new Sorry\Node("square");
        $node2 = new Sorry\Node("safe", "blue");
        $node3 = new Sorry\Node("safe", "blue");
        $node4 = new Sorry\Node("home", "blue");
        $node1->addTo($node2);
        $node2->addTo($node3);
        $node3->addTo($node4);
        $player1 = new Sorry\Player("blue", "player 1");
        $player1Pawn1 = new Sorry\Pawn($player1);
        $node1->searchReachable(3, $player1Pawn1->getColor());
        $this->assertTrue($node4->checkReachable());
    }
    public function testDeadEnd(){
        //tests what searchreachable does when it hits a dead end
        $node1 = new Sorry\Node("square");
        $node2 = new Sorry\Node("square");
        $node3 = new Sorry\Node("square");
        $node1->addTo($node2);
        $node2->addTo($node3);
        $player1 = new Sorry\Player("red", "player 1");
        $player1Pawn1 = new Sorry\Pawn($player1);
        $node1->addPawn($player1Pawn1);
        $node1->searchReachable(5, $player1Pawn1->getColor());
        $this->assertFalse($node1->checkReachable());
        $this->assertFalse($node2->checkReachable());
        $this->assertFalse($node3->checkReachable());
    }
    public function SameColorPawn(){
        //testing if a pawn lands on a node that already has a pawn of the same color
        $node1 = new Sorry\Node("square");
        $node2 = new Sorry\Node("square");
        $node3 = new Sorry\Node("square");
        $node1->addTo($node2);
        $node2->addTo($node3);
        $player1 = new Sorry\Player("red", "player 1");
        $player1Pawn1 = new Sorry\Pawn($player1);
        $player1Pawn2 = new Sorry\Pawn($player1);
        $node1->addPawn($player1Pawn1);
        $node3->addPawn($player1Pawn2);
        $node1->searchReachable(2, $player1Pawn1->getColor());
        $this->assertFalse($node1->checkReachable());
        $this->assertFalse($node2->checkReachable());
        $this->assertFalse($node3->checkReachable());
    }


}