# k-nearest

## 概要
k近傍法によってA地点の予測値を求めためのクラス作成

ユニットテストも実装

## How to use
```PHP
$k = 3; // k近傍法のk値
$points = [
 　　　["x" => 10, "y" => -4, "value" => 3000],
 　　　["x" => 0, "y" => 0, "value" => 1000],
 　　　["x" => 2, "y" => 3, "value" => 2000],
]; // 座標及び値データ
$a = ["x" => 1, "y" => 1]; // A地点の座標
$kNearest = new Knearest($points, $k, $a);
$guess = $kNearest->calcKnearest(); // 予測値
```

## ユニットテスト実行方法
1. `composer install`
1. `./vendor/bin/phpunit tests`