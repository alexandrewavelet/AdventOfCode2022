<?php

namespace App\Days;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use NumberFormatter;

class One extends Day
{
    public string $title = 'Calorie Counting';

    public ?Collection $elves = null;

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
        <p>The top 3 Elves are carrying <b>{$this->findCaloriesForTop(3)}<b> calories.</p>
HTML;
    }

    /**
     * @return array{elve: int, calories: int}
     */
    public function findMaxCalories(): array
    {
        $maxCalories = $this->findCaloriesForTop();

        return [$this->getElves()->search($maxCalories) + 1, $maxCalories];
    }

    public function findCaloriesForTop(int $n = 1): int
    {
        return $this->getElves()
            ->sortDesc()
            ->slice(0, $n)
            ->sum();
    }

    private function getElves(): Collection
    {
        if ($this->elves === null) {
            $this->elves = $this->dataset
                ->map(fn ($value) => is_numeric($value) ? (int)$value : null)
                ->chunkWhile(fn ($value) => $value !== null)
                ->map(fn ($foods) => $foods->sum())
            ;
        }

        return $this->elves;
    }

    private function ordinal(int $number): string
    {
        $numberFormatter = new NumberFormatter(App::currentLocale(), NumberFormatter::ORDINAL);

        return $numberFormatter->format($number);
    }
}
