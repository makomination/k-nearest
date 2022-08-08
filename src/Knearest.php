<?php

declare(strict_types=1);

/**
 * k近傍法でAの値の推定値を求める
 */
final class Knearest
{
    /** 距離でソートされた$points */
    private array $dataset;
    /** k近傍法のk */
    private int $k;
    /** 点aの座標 */
    private array $a;

    public function __construct(array $points, int $k, array $a)
    {
        $this->a = $a;
        $this->k = $k;
        $this->dataset = $this->sortPoints($points);
    }

    /**
     * $pointsを距離順にソートしたものを返す
     * 
     * @param array $points 各要素の配列にkey"x"と"y"があること
     */
    public function sortPoints(array $points): array
    {
        usort($points, function ($a, $b) {
            return $this->calcDistance($a) <=> $this->calcDistance($b);
        });
        return $points;
    }

    /**
     * 距離(の2乗)を計算
     * 
     * @param array $point key"x"と"y"があること
     */
    public function calcDistance(array $point): float
    {
        return ($point["x"] - $this->a["x"]) * ($point["x"] - $this->a["x"]) +
            ($point["y"] - $this->a["y"]) * ($point["y"] - $this->a["y"]);
    }

    /**
     * k近傍法の計算
     */
    public function calcKnearest(): float
    {
        $sum = 0.0;
        $targetDataSet = array_slice($this->dataset, 0, $this->k);
        foreach ($targetDataSet as $data) {
            $sum += $data['value'];
        }
        return $sum / count($targetDataSet);
    }
}
