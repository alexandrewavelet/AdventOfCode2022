<?php

namespace App\Days;

use App\Enums\RPS;
use App\Enums\RPSOutcome;

class Two extends Day
{
    public string $title = 'Rock Paper Scissors';

    public const RPS_MAPPING = [
        'A' => RPS::Rock,
        'B' => RPS::Paper,
        'C' => RPS::Scissors,
        'X' => RPS::Rock,
        'Y' => RPS::Paper,
        'Z' => RPS::Scissors,
    ];

    public function description(): string
    {
        return <<<HTML
        <p>Win the Rock-Paper-Scissors Elvish Tournament 2022.<p>
HTML;
    }

    public function firstPuzzle(): string
    {
        return <<<HTML
            <p>Following the secret strategy giving the answers, I should have {$this->calculateRPSScoreWithAnswersStrategy()} points.</p>
HTML;
    }

    public function secondPuzzle(): string
    {
        return <<<HTML
            <p>Following the secret strategy giving the round outcome, I should have {$this->calculateRPSScoreWithOutcomeStrategy()} points.</p>
HTML;
    }

    public function calculateRPSScoreWithAnswersStrategy(): int
    {
        $score = 0;

        foreach ($this->dataset as $round) {
            [$play, $opponentPlay] = $this->parseRound($round);

            $playScore = match ($play) {
                RPS::Rock => 1,
                RPS::Paper => 2,
                RPS::Scissors => 3,
            };
            $resultScore = match ($this->solveRPS($play, $opponentPlay)) {
                RPSOutcome::Lose => 0,
                RPSOutcome::Draw => 3,
                RPSOutcome::Win => 6,
            };

            $score += $playScore + $resultScore;
        }

        return $score;
    }

    public function calculateRPSScoreWithOutcomeStrategy(): int
    {
        return 0;
    }

    public function solveRPS(RPS $play, RPS $opponentPlay): RPSOutcome
    {
        $valueSolver = function (RPS $play) {
            return match ($play) {
                RPS::Rock => 0,
                RPS::Paper => 1,
                RPS::Scissors => 2,
            };
        };

        $playValue = $valueSolver($play);
        $opponentPlayValue = $valueSolver($opponentPlay);

        return match (abs($playValue - $opponentPlayValue)) {
            1 => $playValue > $opponentPlayValue ? RPSOutcome::Win : RPSOutcome::Lose,
            2 => $playValue > $opponentPlayValue ? RPSOutcome::Lose : RPSOutcome::Win,
            default => RPSOutcome::Draw,
        };
    }

    /**
     * @return array{play: RPS, opponentPlay: RPS}
     */
    private function parseRound(string $round): array
    {
        preg_match('/(?<opponentPlay>[A-C]) (?<play>[X-Z])/', $round, $matches);

        return [self::RPS_MAPPING[$matches['play']], self::RPS_MAPPING[$matches['opponentPlay']]];
    }
}
