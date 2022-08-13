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
        $points = [
            ["x" => 0, "y" => 0, "value" => 1000],
            ["x" => 2, "y" => 3, "value" => 1590],
        ];
        $a = ["x" => 1, "y" => 1];
        $this->assertEquals(2.0, Knearest::calcDistance($points[0], $a));
        $this->assertEquals(5.0, Knearest::calcDistance($points[1], $a));
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
        $sorted = Knearest::sortPoints($points, $a);
        $this->assertEquals(["x" => 0, "y" => 0, "value" => 1000], $sorted[0]);
        $this->assertEquals(["x" => 2, "y" => 3, "value" => 1590], $sorted[1]);
        $this->assertEquals(["x" => 10, "y" => -4, "value" => 3000], $sorted[2]);
    }

    /**
     * 正しくk近傍法が計算されること
     */
    public function testCanBeCalculatedForKNearest(): void
    {
        // kがデータの数以上
        $k = 3;
        $points = [
            ["x" => 10, "y" => -4, "value" => 3000],
            ["x" => 0, "y" => 0, "value" => 1000],
            ["x" => 2, "y" => 3, "value" => 2000],
        ];
        $a = ["x" => 1, "y" => 1];
        $kNearest = new Knearest($points, $k, $a);
        $guess = $kNearest->calcKnearest();
        $this->assertEquals((1000 + 2000 + 3000) / 3, $guess);
        $k = 10;
        $kNearest = new Knearest($points, $k, $a);
        $guess = $kNearest->calcKnearest();
        $this->assertEquals((1000 + 2000 + 3000) / 3, $guess);

        // kがデータの数未満
        $k = 2;
        $kNearest = new Knearest($points, $k, $a);
        $guess = $kNearest->calcKnearest();
        $this->assertEquals((1000 + 2000) / 2, $guess);
    }
}
