<?php



class CardsTest extends \PHPUnit\Framework\TestCase
{


    public function test_cards()
    {
        $Cards = new Sorry\Cards();
        $this->assertInstanceOf('Sorry\Cards', $Cards);

        $this->assertEquals(0, $Cards->getCurrentCardValue());

        $deck = $Cards->getCardStack();
        $this->assertEquals(45, count($deck));

        $cardOneCount = 0;
        $cardTwoCount = 0;
        $cardThreeCount = 0;
        $cardFourCount = 0;
        $cardFiveCount = 0;
        $cardSevenCount = 0;
        $cardEightCount = 0;
        $cardTenCount = 0;
        $cardElevenCount = 0;
        $cardTwelveCount = 0;
        $cardSorryCount = 0;
        $errorCount = 0;
        foreach ($deck as $card) {
            $this->assertInstanceOf('Sorry\Card', $card);

            $value = $card->getValue();
            if ($value == Sorry\Cards::ONE_CARD) {
                $cardOneCount += 1;
            }
            elseif ($value == Sorry\Cards::TWO_CARD) {
                $cardTwoCount += 1;
            }
            elseif ($value == Sorry\Cards::THREE_CARD) {
                $cardThreeCount += 1;
            }
            elseif ($value == Sorry\Cards::FOUR_CARD) {
                $cardFourCount += 1;
            }
            elseif ($value == Sorry\Cards::FIVE_CARD) {
                $cardFiveCount += 1;
            }
            elseif ($value == Sorry\Cards::SEVEN_CARD) {
                $cardSevenCount += 1;
            }
            elseif ($value == Sorry\Cards::EIGHT_CARD) {
                $cardEightCount += 1;
            }
            elseif ($value == Sorry\Cards::TEN_CARD) {
                $cardTenCount += 1;
            }
            elseif ($value == Sorry\Cards::ELEVEN_CARD) {
                $cardElevenCount += 1;
            }
            elseif ($value == Sorry\Cards::TWELVE_CARD) {
                $cardTwelveCount += 1;
            }
            elseif ($value == Sorry\Cards::SORRY_CARD) {
                $cardSorryCount += 1;
            }
            else {
                $errorCount += 1;
            }
        }

        $this->assertEquals(5, $cardOneCount);
        $this->assertEquals(4, $cardTwoCount);
        $this->assertEquals(4, $cardThreeCount);
        $this->assertEquals(4, $cardFourCount);
        $this->assertEquals(4, $cardFiveCount);
        $this->assertEquals(4, $cardSevenCount);
        $this->assertEquals(4, $cardEightCount);
        $this->assertEquals(4, $cardTenCount);
        $this->assertEquals(4, $cardElevenCount);
        $this->assertEquals(4, $cardTwelveCount);
        $this->assertEquals(4, $cardSorryCount);

        $this->assertEquals(0, $errorCount);

    }
}