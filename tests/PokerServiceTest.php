<?php

namespace App\Tests;

use App\Enum\GameResult;
use App\Service\PokerService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class PokerServiceTest extends TestCase
{
    private PokerService $pokerService;

    protected function setUp(): void
    {
        // Initialisation du service à tester
        $this->pokerService = new PokerService();
    }

    public function testGetValues(): void
    {
        $result = $this->pokerService->getValues(["KS", "2H", "5C", "JD", "TD"]);
        $this->assertEquals(["K", "2", "5", "J", "T"], $result);
    }

    public function testGetColors(): void
    {
        $result = $this->pokerService->getColors(["KS", "2H", "5C", "JD", "TD"]);
        $this->assertEquals(["S", "H", "C", "D", "D"], $result);
    }

    public function testCheckPairMinimumTrue(): void
    {
        $result = $this->pokerService->checkPairMinimum(["K", "K", "5", "J", "T"]);
        $this->assertEquals(true, $result);
    }

    public function testcheckPairMinimumFalse(): void
    {
        $result = $this->pokerService->checkPairMinimum(["K", "2", "5", "J", "T"]);
        $this->assertEquals(false, $result);
    }

    public function testcheckPairMinimumEmptyKey(): void
    {
        $result = $this->pokerService->checkPairMinimum(["", "", "", "", ""]);
        $this->assertEquals(false, $result);
    }

    public function testcheckFlushTrue(): void
    {
        $result = $this->pokerService->checkFlush(["S", "S", "S", "S", "S"]);
        $this->assertEquals(true, $result);
    }

    public function testcheckFlushFalse(): void
    {
        $result = $this->pokerService->checkFlush(["S", "S", "S", "S", "H"]);
        $this->assertEquals(false, $result);
    }

    public function testCheckStraightFalse(): void
    {
        $result = $this->pokerService->checkStraight(["K", "K", "5", "J", "T"]);
        $this->assertEquals(false, $result);
    }

    public function testCheckStraightTrue(): void
    {
        $result = $this->pokerService->checkStraight(["2", "3", "4", "5", "6"]);
        $this->assertEquals(true, $result);
    }

    public function testCheckStraightTrueNotInOrder(): void
    {
        $result = $this->pokerService->checkStraight(["2", "4", "3", "5", "6"]);
        $this->assertEquals(true, $result);
    }

    public function testCheckStraightTrueNotInOrderAndBigCards(): void
    {
        $result = $this->pokerService->checkStraight(["T", "J", "K", "Q", "A"]);
        $this->assertEquals(true, $result);
    }

    public function testCheckHighCardTie(): void
    {
        $result = $this->pokerService->checkHighCard(["K", "2", "5", "J", "T"]);
        $this->assertEquals(GameResult::Tie, $result);
    }

    public function testCheckHighCardWin(): void
    {
        $result = $this->pokerService->checkHighCard(["A", "2", "5", "J", "T"]);
        $this->assertEquals(GameResult::Win, $result);
    }

    public function testCheckHighCardLoss(): void
    {
        $result = $this->pokerService->checkHighCard(["Q", "2", "5", "J", "T"]);
        $this->assertEquals(GameResult::Lose, $result);
    }

    public function testCompareWithPair()
    {
        $result = $this->pokerService->compareWith("KS KH 5C JD TD");
        $this->assertEquals(GameResult::Win, $result);
    }
}
