<?php

declare(strict_types=1);
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

final class KnearestTest extends TestCase
{
    /**
     * 距離を計算できること
     */
    public function testCanBeCalculatedForDistance(): void
    {
        $k = 3;
        $points = [
            ["x" => 0, "y" => 0, "value" => 1000],
            ["x" => 2, "y" => 3, "value" => 1590],
        ];
        $a = ["x" => 1, "y" => 1];
        $kNearest = new Knearest($points, $k, $a);
        $this->assertEquals(2, $kNearest->calcDistance($points[0]));
        $this->assertEquals(5, $kNearest->calcDistance($points[1]));
    }

    /**
     * 距離順にソートされること
     */
    public function testCanBeSortedByAsc(): void
    {
        $k = 3;
        $points = [
            ["x" => 10, "y" => -4, "value" => 3000],
            ["x" => 0, "y" => 0, "value" => 1000],
            ["x" => 2, "y" => 3, "value" => 1590],
        ];
        $a = ["x" => 1, "y" => 1];
        $kNearest = new Knearest($points, $k, $a);
        $sorted = $kNearest->sortPoints($points);
        $this->assertEquals(["x" => 0, "y" => 0, "value" => 1000], $sorted[0]);
        $this->assertEquals(["x" => 2, "y" => 3, "value" => 1590], $sorted[1]);
        $this->assertEquals(["x" => 10, "y" => -4, "value" => 3000], $sorted[2]);
    }

    /**
     * 正しくk近傍法が計算されること
     */
    public function testCanBeCalculatedForKNearest(): void
    {
        $k = 3;
        $points = [
            ["x" => 10, "y" => -4, "value" => 3000],
            ["x" => 0, "y" => 0, "value" => 1000],
            ["x" => 2, "y" => 3, "value" => 2000],
        ];
        $a = ["x" => 1, "y" => 1];
        $kNearest = new Knearest($points, $k, $a);
        $avg = $kNearest->calcKnearest();
        // kとデータの数以上
        $this->assertEquals((1000 + 2000 + 3000) / 3, $avg);
        // kがデータの数未満
        $k = 2;
        $kNearest = new Knearest($points, $k, $a);
        $avg = $kNearest->calcKnearest();
        $this->assertEquals((1000 + 2000) / 2, $avg);
    }
}
