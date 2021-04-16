<?php


namespace Sorry;

/**
 * Class representing the sliders located on the board.
 */
class Slider extends Node
{
    public function GetPlayersOnSlider(){

    }

    /**
     * @return mixed
     */
    public function getSliderSize()
    {
        return $this->sliderSize;
    }

    /**
     * @return mixed
     */
    public function getSliderColor()
    {
        return $this->sliderColor;
    }

    private $sliderColor;
    private $sliderSize;
}