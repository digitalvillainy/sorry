<?php


namespace Sorry;


/**
 * Class to represent a playing card in our game Sorry!
 */
class Card
{
    /**
     * Constructor
     *
     * Every card has an index into the array in the Cards class.
     * These are values starting at 1.
     * They also have an assigned
     * card value, which is what the user sees.
     *
     * @param int $ndx Index into the array of cards
     * @param int $value The assigned card value
     */
    public function __construct($ndx, $value) {
        $this->ndx = $ndx;
        $this->value = $value;
    }

    /**
     * Get the index into the Cards array of a given card
     * @return int Index value starting at 1
     */
    public function getNdx() {
        return $this->ndx;
    }

    /**
     * Get the value of the
     * @return int Value of given card
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Has this card been drawn from the Cards stack?
     * @return bool True if drawn otherwise False
     */
    public function isDrawn() {
        return $this->drawn;
    }



    // if the card is drawn and should no longer be pulled from Cards stack
    private $drawn = false;
    private $ndx;      // index into our card stack
    private $value;    // the value of the playing card

}