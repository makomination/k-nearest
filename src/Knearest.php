<?php

declare(strict_types=1);

/**
 * k近傍法でAの値の推定値を求める
 */
final class Knearest
{

    /** k近傍法のk */
    private int $k;
    /** 点aの座標 */
    private array $a;
    /** 距離でソートされた$points */
    private array $sortedDataset;

    public function __construct(array $points, int $k, array $a)
    {
        $this->k = $k;
        $this->a = $a;
        $this->sortedDataset = self::sortPoints($points, $this->a);
    }

    /**
     * $pointsを点aからの距離順にソートしたものを返す
     * 
     * @param array $points 各要素の配列にkey"x"と"y"があること
     * @param array $a 点aの座標 (["x": float, "y": float])
     */
    static function sortPoints(array $points, array $a): array
    {
        usort($points, function ($x, $y) use ($a) {
            return self::calcDistance($x, $a) <=> self::calcDistance($y, $a);
        });
        return $points;
    }

    /**
     * 点aからの距離(の2乗)を計算
     * 
     * @param array $point 各座標と値 (["x": float, "y": float, "value": float])
     * @param array $a 点aの座標 (["x": float, "y": float])
     */
    static function calcDistance(array $point, array $a): float
    {
        return ($point["x"] - $a["x"]) * ($point["x"] - $a["x"]) +
            ($point["y"] - $a["y"]) * ($point["y"] - $a["y"]);
    }

    /**
     * k近傍法の計算
     */
    public function calcKnearest(): float
    {
        $sum = 0.0;
        $targetDataSet = array_slice($this->sortedDataset, 0, $this->k);
        foreach ($targetDataSet as $data) {
            $sum += $data['value'];
        }
        return $sum / count($targetDataSet);
    }
}
