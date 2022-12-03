<?php

namespace App\Days;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use NumberFormatter;

class One extends Day
{
    public $title = 'Calorie Counting';

    public function description(): string
    {
        return <<<HTML
        <p>Find the Elve that carries the most calories, and how much of it.<p>
HTML;
    }

    public function firstPuzzle(): string
    {
        [$elve, $calories] = $this->findMaxCalories();

        return <<<HTML
            <p>The <b>{$this->ordinal($elve)}</b> Elve is the strongest and carries <b>$calories</b> calories.</p>
HTML;
    }

    public function secondPuzzle(): string
    {

        return <<<HTML
        <p>TBD</p>
HTML;
    }

    /**
     * @return array{elve: int, calories: int}
     */
    public function findMaxCalories(): array
    {
        $elves = $this->calculateElvesStock();

        $maxCalories = $elves->max();

        return [$elves->search($maxCalories) + 1, $maxCalories];
    }

    private function calculateElvesStock(): Collection
    {
        return $this->dataset->map(fn ($value) => is_numeric($value) ? (int)$value : null)
            ->chunkWhile(fn ($value) => $value !== null)
            ->map(fn ($foods) => $foods->sum())
        ;
    }

    private function ordinal(int $number): string
    {
        $numberFormatter = new NumberFormatter(App::currentLocale(), NumberFormatter::ORDINAL);

        return $numberFormatter->format($number);
    }
}
