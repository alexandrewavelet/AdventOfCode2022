<?php

namespace Tests\Unit;

use App\Days\Two;
use App\Enums\RPS;
use App\Enums\RPSOutcome;
use PHPUnit\Framework\TestCase;

class TwoTest extends TestCase
{
    /**
     * @dataProvider provideRPSRounds
     */
    public function test_it_solves_rps(RPS $play, RPS $opponentPlay, RPSOutcome $expectedOutcome)
    {
        $day = new Two();

        $this->assertEquals($expectedOutcome, $day->solveRPS($play, $opponentPlay));
    }

    public function provideRPSRounds(): array
    {
        return [
            'Rock vs Rock: Draw' => [RPS::Rock, RPS::Rock, RPSOutcome::Draw],
            'Rock vs Paper: Lose' => [RPS::Rock, RPS::Paper, RPSOutcome::Lose],
            'Rock vs Scissors: Win' => [RPS::Rock, RPS::Scissors, RPSOutcome::Win],
            'Paper vs Rock: Win' => [RPS::Paper, RPS::Rock, RPSOutcome::Win],
            'Paper vs Paper: Draw' => [RPS::Paper, RPS::Paper, RPSOutcome::Draw],
            'Paper vs Scissors: Lose' => [RPS::Paper, RPS::Scissors, RPSOutcome::Lose],
            'Scissors vs Rock: Lose' => [RPS::Scissors, RPS::Rock, RPSOutcome::Lose],
            'Scissors vs Paper: Win' => [RPS::Scissors, RPS::Paper, RPSOutcome::Win],
            'Scissors vs Scissors: Draw' => [RPS::Scissors, RPS::Scissors, RPSOutcome::Draw],
        ];
    }

    public function test_calculate_rps_score_with_answers()
    {
        $day = new Two(collect([
            'A Y',
            'B X',
            'C Z',
        ]));

        $score = $day->calculateRPSScoreWithAnswersStrategy();

        $this->assertEquals(15, $score);
    }

    public function test_calculate_rps_score_with_strategy()
    {
        $day = new Two(collect([
            'A Y',
            'B X',
            'C Z',
        ]));

        $score = $day->calculateRPSScoreWithOutcomeStrategy();

        $this->assertEquals(12, $score);
    }
}
