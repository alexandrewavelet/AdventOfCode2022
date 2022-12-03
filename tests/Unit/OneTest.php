<?php

namespace Tests\Unit;

use App\Days\One;
use PHPUnit\Framework\TestCase;

class OneTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_find_most_calories()
    {
        $one = new One(collect([
            '1', '2', '3', '', '4', '5', '', '1', '1'
        ]));

        [$elve, $calories] = $one->findMaxCalories();

        $this->assertEquals(2, $elve);
        $this->assertEquals(9, $calories);
    }
}
