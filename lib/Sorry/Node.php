<?php


namespace Sorry;


/**
 * A node in the game graph
 */
class Node {

    /**
     * constructor for node class
     * @param string $type type of node(square or start or home or safe or empty or slider)
     * @param string $color color of square(only applicable to home squares)
     */
    public function __construct($type, $color = "None"){
        $this->type = $type;
        $this->color = $color;
    }

    /**
     * Add a neighboring node
     * @param Node $to Node we can step into
     * @param string $direction backwards or forward direction neighbor
     */
    public function addTo($to, $direction = "forward") {

        if($direction == "backwards"){
            $this->behind[] = $to;
        }
        else{
            $this->to[] = $to;
        }

    }
    public function getColor(){
        return $this->color;
    }
    /**
     * Get neighbors function
     * @return array of neighboring nodes
     */
    public function getNeighbors(){
        return $this->to;
    }
    /**
     * Get backwards neighbors function
     * @return array of backwards neighboring nodes
     */
    public function getBackwardNeighbors(){
        return $this->behind;
    }
    /**
     * add player piece on top of node
     * @param Pawn $pawn
     */
    public function addPawn($pawn){
        $this->player = $pawn;
        $this->blocked = true;
    }
    /**
     * remove player from node(player moved off of node
     */
    public function removePawn(){
        $this->player = Null;
        $this->blocked = false;
    }
    /**
     * get player
     * @return Pawn player currently on node
     */
    public function getCurrentPawn(){
        return $this->player;
    }
    /**
     * return true if node is vacant
     * @return bool if empty or not
     */
    public function isEmpty(){
        if($this->player == Null){
            return true;
        }
        
        return false;

    }

    /**
     * resets the node values to be called after a pawn moves onto a node
     */

    public function resetNodeValues(){
        $this->reachable = false;
        $this->onPath = false;
        $this->safeflag = false;
    }

    /**
     * @param string $color color of slider
     * @param int $length length of slider
     */
    public function setSliderProperties(string $color, int $length){
        $this->sliderColor = $color;
        $this->sliderLength = $length;
    }

    /**
     * returns color of slider
     */
    public function getSliderColor(){
        return $this->sliderColor;
    }

    /**
     * returns length of slider
     */
    public function getSliderLength(){
        return $this->sliderLength;
    }

    /**
     * returns type of node
     */
    public function getType(){
        return $this->type;
    }

    /**
     * return whether or not node is reachable
     * @return bool if node is reachable or not
     */
    public function checkReachable(){
        return $this->reachable;
    }


    /**
     * check if node is reachable with current path, call this on the node
     * that the player is in with count from card
     * @param $distance
     * @param string $pawnColor
     */

    public function searchReachable($distance, $pawnColor) {
        // The path is done if it at the end of the distance
        if($distance === 0) {
            //$this->reachable = true;
            //this if condition allows for path forking

            if($this->getType() == "square" or $this->getType() == "slider"){
                $this->reachable = true;


            }
            if ($this->getType() == "safe"){
                if($this->getColor() == $pawnColor){
                    $this->reachable = true;


                }


            }
            if ($this->getType() == "home"){
                if($this->getColor() == $pawnColor){
                    $this->reachable = true;


                }


            }
            if($this->blocked){
                if($this->getCurrentPawn()->getColor() == $pawnColor){
                    $this->reachable = false;
                }
            }


            return;
        }

        $this->onPath = true;
        $this->safeflag = false;
        foreach($this->to as $to) {
            if($to->getType() == "safe" and $to->getColor() == $pawnColor){
                $this->safeflag = true;
            }
        }

        foreach($this->to as $to) {
            if(!$to->onPath) {
                if($to->getColor() == $pawnColor){

                    //set a safeflag if pawncolor matches the safe zone color
                    //this will now only allow safe zone squares to be reachable for this pawn
                    if ($to->getType() == "safe") {
                        $this->safeflag = true;
                    }


                }
                else{
                    //skip past safe zones of different colors
                    if ($to->getType() == "safe"){
                        $this->safeflag = false;
                        continue;
                    }

                }
                //when safe flag is set it only allows safe zone nodes to be reachable
                if ($this->safeflag){
                    if ($to->getType() == "safe" and $to->getColor() == $pawnColor){
                        $to->searchReachable($distance-1, $pawnColor);
                    }
                    else if($to->getType() == "home" and $to->getColor() == $pawnColor){
                        $to->searchReachable($distance-1, $pawnColor);
                    }
                }
                if (!$this->safeflag){
                    $to->searchReachable($distance-1, $pawnColor);
                }



            }

        }


        $this->onPath = false;
    }

    //didnt implement pathforking in backwards bc im not sure we need it
    public function backwardsSearchReachable($distance) {
        // The path is done if it at the end of the distance
        if($distance === 0) {
            $this->reachable = true;

            return;
        }

        $this->onPath = true;

        foreach($this->behind as $behind) {
            if(!$behind->onPath) {
                $behind->backwardsSearchReachable($distance-1);
            }

        }

        $this->onPath = false;
    }




    // Pointers to adjacent nodes
    private $to = [];
    //pointers to adjacent backwards nodes
    private $behind = [];
    //type of node
    private $type;
    //current player on node
    private $player = Null;
    // This node is blocked and cannot be visited
    private $blocked = false;
    // This node is on a current path
    private $onPath = false;
    // Node is reachable in the current move
    private $reachable = false;
    //color of node - only applicable to start, safe and home type nodes
    private $color = Null;
    private $sliderColor = Null;
    private $sliderLength = Null;
    private $safeflag = false;
}