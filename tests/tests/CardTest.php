<?php


class CardTest extends \PHPUnit\Framework\TestCase
{
    public function test_card() {
        $cardOne = new Sorry\Card(1, Sorry\Cards::ONE_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardOne);
        $this->assertEquals(1, $cardOne->getNdx());
        $this->assertEquals(Sorry\Cards::ONE_CARD, $cardOne->getValue());

        $cardTwo = new Sorry\Card(2, Sorry\Cards::TWO_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardTwo);
        $this->assertEquals(2, $cardTwo->getNdx());
        $this->assertEquals(Sorry\Cards::TWO_CARD, $cardTwo->getValue());

        $cardThree = new Sorry\Card(3, Sorry\Cards::THREE_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardThree);
        $this->assertEquals(3, $cardThree->getNdx());
        $this->assertEquals(Sorry\Cards::THREE_CARD, $cardThree->getValue());

        $cardFour = new Sorry\Card(4, Sorry\Cards::FOUR_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardFour);
        $this->assertEquals(4, $cardFour->getNdx());
        $this->assertEquals(Sorry\Cards::FOUR_CARD, $cardFour->getValue());

        $cardFive = new Sorry\Card(5, Sorry\Cards::FIVE_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardFive);
        $this->assertEquals(5, $cardFive->getNdx());
        $this->assertEquals(Sorry\Cards::FIVE_CARD, $cardFive->getValue());

        $cardSeven = new Sorry\Card(6, Sorry\Cards::SEVEN_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardSeven);
        $this->assertEquals(6, $cardSeven->getNdx());
        $this->assertEquals(Sorry\Cards::SEVEN_CARD, $cardSeven->getValue());

        $cardEight = new Sorry\Card(7, Sorry\Cards::EIGHT_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardEight);
        $this->assertEquals(7, $cardEight->getNdx());
        $this->assertEquals(Sorry\Cards::EIGHT_CARD, $cardEight->getValue());

        $cardTen = new Sorry\Card(8, Sorry\Cards::TEN_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardTen);
        $this->assertEquals(8, $cardTen->getNdx());
        $this->assertEquals(Sorry\Cards::TEN_CARD, $cardTen->getValue());

        $cardEleven = new Sorry\Card(9, Sorry\Cards::ELEVEN_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardEleven);
        $this->assertEquals(9, $cardEleven->getNdx());
        $this->assertEquals(Sorry\Cards::ELEVEN_CARD, $cardEleven->getValue());

        $cardTwelve = new Sorry\Card(10, Sorry\Cards::TWELVE_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardTwelve);
        $this->assertEquals(10, $cardTwelve->getNdx());
        $this->assertEquals(Sorry\Cards::TWELVE_CARD, $cardTwelve->getValue());

        $cardSorry = new Sorry\Card(11, Sorry\Cards::SORRY_CARD);
        $this->assertInstanceOf('Sorry\Card', $cardSorry);
        $this->assertEquals(11, $cardSorry->getNdx());
        $this->assertEquals(Sorry\Cards::SORRY_CARD, $cardSorry->getValue());
    }

}