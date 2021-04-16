<?php


namespace Sorry;

require_once('Card.php');


/**
 * A class to represent our card stack in our Sorry! game
 */
class Cards
{
    const NUM_CARDS = 45;      // num of total playing cards
    const NUM_CARD_ONE = 5;    // num of playing cards of type 1
    const NUM_CARD_OTHER = 4;  // num of other playing card types

    const ONE_CARD = 1;       // the value of the one card
    const TWO_CARD = 2;       // the value of the two card
    const THREE_CARD = 3;     // the value of the three card
    const FOUR_CARD = -4;      // the value of the four card
    const FIVE_CARD = 5;      // the value of the five card
    const SEVEN_CARD = 7;     // the value of the seven card
    const EIGHT_CARD = 8;     // the value of the eight card
    const TEN_CARD = 10;      // the value of the ten card
    const ELEVEN_CARD = 11;   // the value of the eleven card
    const TWELVE_CARD = 12;   // the value of the twelve card
    const SORRY_CARD = 13;    // the value of the sorry card

    /**
     * Constructor
     *
     * Calls createDeck() to construct the stack of cards for our Sorry! game
     * Our stack will hold 45 cards total (5) 1 cards
     * and (4) of every other card
     *
     */
    public function __construct() {
        $this->createDeck();
    }

    /**
     * Create a stack of cards for our Sorry! game
     * Our stack holds 45 cards total (5) 1 cards
     * and (4) of every other card, per rules
     *
     * Each item in the card stack is an object of type Card(index, value)
     * where index is the index into the card stack (our deck)
     * and value is the value of the card (card1 has value of type int 1, etc..)
     *
     */
    public function createDeck() {
        // construct 45 cards
        $cards = [];
        // 5 one cards
        for ($i = 0; $i < self::NUM_CARD_ONE; $i++) {
            $cards[] = self::ONE_CARD;
        }
        // 4 of every other card
        for($i = 0; $i < self::NUM_CARD_OTHER; $i++) {
            $cards[] = self::TWO_CARD;
            $cards[] = self::THREE_CARD;
            $cards[] = self::FOUR_CARD;
            $cards[] = self::FIVE_CARD;
            $cards[] = self::SEVEN_CARD;
            $cards[] = self::EIGHT_CARD;
            $cards[] = self::TEN_CARD;
            $cards[] = self::ELEVEN_CARD;
            $cards[] = self::TWELVE_CARD;
            $cards[] = self::SORRY_CARD;
        }
        // shuffle cards for randomized order
        shuffle($cards);

        // add them to cardStack as card objects
        // starting at index = 1
        for($i = 1; $i <= self::NUM_CARDS; $i++) {
            $this->cardStack[$i] = new Card($i, $cards[$i - 1]);
        }

        // and reset card index for the case where we already used all 45 cards
        $this->currentCardIndex = 1;
    }

    /**
     * Draw a card from the card stack (our deck of cards)
     * @return Card the current card object (of type Card) being drawn
     */
    public function drawCard() {
        // if we have gone through the entire 45 card deck
        if ($this->currentCardIndex > 45) {
            // set previous card to current card
            $this->previousCard = $this->currentCard;
            $this->previousCardSet = true;
            // then need to create new deck, shuffle it and reset current card index
            $this->createDeck();
        }
        else {
            $this->previousCardSet = false;
        }
        // get the current card and set $this->currentCard to it
        $this->currentCard = $this->cardStack[$this->currentCardIndex];

        // get the previous card

        // if we didn't already set it
        if ($this->previousCardSet == false) {
            // make sure current card is not the first ever card drawn
            if ($this->currentCardIndex == 1) {
                // there is no previous card
                $this->previousCard = null;
            }
            else {
                $this->previousCard = $this->cardStack[$this->currentCardIndex - 1];
            }
        }

        // increment current card index for next draw and return the current Card object
        $this->currentCardIndex += 1;
        return $this->currentCard;
    }

    /**
     * Getter for the value (int) of the current card in play
     * value is the value of the current card (card1 has value of type int 1, etc..)
     * @return int The value of the card last drawn
     */
    public function getCurrentCardValue() {
        if ($this->currentCard == null) {
            return 0;
        }
        return $this->currentCard->getValue();
    }

    /**
     * @return array
     */
    public function getCardStack(): array
    {
        return $this->cardStack;
    }

    /**
     * @return mixed
     */
    public function getPreviousCard()
    {
        return $this->previousCard;
    }

    /**
     * Getter for the value (int) of the previous card in play
     * value is the value of the current card (card1 has value of type int 1, etc..)
     * @return int The value of the card drawn prior to current card in play
     */
    public function getPreviousCardValue() {
        if ($this->previousCard == null) {
            return 0;
        }
        return $this->previousCard->getValue();
    }



    private $currentCardIndex = 1;        // index of the current card (deck index starts at 1)
    private $cardStack = [];              // the stack of playing cards
    private $currentCard;                 // the current card object we are on
    private $previousCard;                // the previous card object, the card drawn before
    private $previousCardSet;             // determine if we need to set previous card

}