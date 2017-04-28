<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/28
 * Time: 10:00
 */
$imagePath = '1.jpg';
$image = imagecreatefromjpeg($imagePath);
$imageSize = getimagesize($imagePath);
$width = $imageSize[0];
$height = $imageSize[1];
$thumb = imagecreatetruecolor(128, 100);
imagecopyresized($thumb, $image, 0, 0, 0, 0, 128, 100, $width, $height);
imagejpeg($thumb, 'thumb.jpg');

$imagePath = 'thumb.jpg';
$image = imagecreatefromjpeg($imagePath);
$imageSize = getimagesize($imagePath);
$width = $imageSize[0];
$height = $imageSize[1];
$ascpix = [' ', '`', '.', '^', ',', ':', '~', '"', '<', '!', 'c', 't', '+', '{', 'i', '7', '?',
    'u', '3', '0', 'p', 'w', '4', 'A', '8', 'D', 'X', '%', '#', 'H', 'W', 'M', 70, 68, 66, 63, 61, 59, 55, 53, 51, 49, 47, 45, 43, 41, 39, 37, 35, 33, 31, 29, 27, 25, 23, 21, 19, 17, 15, 13, 9, 7, 5, 0];
//获取rgb
$imageGray = '';
for ($i = 0; $i < $height; $i++) {
    for ($j = 0; $j < $width; $j++) {
        $rgb = imagecolorat($image, $j, $i);
        //计算灰度
        $red = ($rgb >> 16) & 0xFF;
        $green = ($rgb >> 8) & 0xFF;
        $blue = $rgb & 0xFF;
        $graies = ($red * 19595 + $green * 38469 + $blue * 7472) >> 16;
        //替换字符
        $imageGray .= $ascpix[floor($graies / 8)];
    }
    $imageGray .= "\n";
}
file_put_contents('test.txt', $imageGray);