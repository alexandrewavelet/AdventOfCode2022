<?php

namespace Tests\Unit;

use App\Days\One;
use PHPUnit\Framework\TestCase;

class OneTest extends TestCase
{
    public function test_find_most_calories()
    {
        $one = new One(collect([
            '1', '2', '3', '', // 6
            '4', '5', '', // 9
            '1', '1' // 2
        ]));

        [$elve, $calories] = $one->findMaxCalories();

        $this->assertEquals(2, $elve);
        $this->assertEquals(9, $calories);
    }

    public function test_find_sum_top3_calories()
    {
        $one = new One(collect([
            '1', '2', '3', '', // 6
            '4', '5', '', // 9
            '1', '1', '', '20', '', // 20
            '7', '1', '', // 8
            '5', '1', '', // 6
            '5', '1', '2', // 8
        ]));

        $calories = $one->findCaloriesForTop(3);

        $this->assertEquals(37, $calories);
    }
}
