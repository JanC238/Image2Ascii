<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/28
 * Time: 10:00
 */
class Image
{
    public static function change($imagePath)
    {
        $image = imagecreatefrompng($imagePath);
        $imageSize = getimagesize($imagePath);
        $width = $imageSize[0];
        $height = $imageSize[1];
        $rate = $width / $height;
        $tempWidth = $width * 1;
        $tempHeight = $tempWidth / $rate * 0.3;
        $thumb = imagecreatetruecolor($tempWidth, $tempHeight);
        imagecopyresized($thumb, $image, 0, 0, 0, 0, $tempWidth, $tempHeight, $width, $height);
        imagepng($thumb, './thumb/' . $imagePath);
        $imagePath = './thumb/' . $imagePath;
        $image = imagecreatefrompng($imagePath);
        $imageSize = getimagesize($imagePath);
        $width = $imageSize[0];
        $height = $imageSize[1];
        $ascpix = [' ', '`', '.', '^', ',', ':', '~', '"', '<', '!', 'c', 't', '+', '{', 'i', '7', '?',
            'u', '3', '0', 'p', 'w', '4', 'A', '8', 'D', 'X', '%', '#', 'H', 'W', 'M'];
        $ascpix = array_reverse($ascpix);

        $imageGray = '';
        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                $rgb = @imagecolorat($image, $j, $i);
                $red = ($rgb >> 16) & 0xFF;
                $green = ($rgb >> 8) & 0xFF;
                $blue = $rgb & 0xFF;
                $graies = ($red * 19595 + $green * 38469 + $blue * 7472) >> 16;
                $imageGray .= $ascpix[floor($graies / 8)];
            }
            $imageGray .= "\n";
        }

        return $imageGray;
    }

    public static function readAllDir($dir)
    {
        $result = array();
        $handle = opendir($dir);
        if ($handle) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    $cur_path = $dir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($cur_path)) {
                        $result['dir'][$cur_path] = self::readAllDir($cur_path);
                    } else {
                        $result['file'][] = $cur_path;
                    }
                }
            }
            closedir($handle);
        }
        return $result;
    }

}

//        $ascpix = [' ', '`', '.', '^', ',', ':', '~', '"', '<', '!', 'c', 't', '+', '{', 'i', '7', '?',
//            'u', '3', '0', 'p', 'w', '4', 'A', '8', 'D', 'X', '%', '#', 'H', 'W', 'M', 70, 68, 66, 63, 61, 59, 55, 53, 51, 49, 47, 45, 43, 41, 39, 37, 35, 33, 31, 29, 27, 25, 23, 21, 19, 17, 15, 13, 9, 7, 5, 0];

for ($i = 1; $i < 9999; $i++) {
    $fileName = './image/Bad_Apple (' . $i . ').png';
    if (file_exists($fileName)) {
        echo @Image::change($fileName);
//        file_put_contents('test.txt', Image::change($fileName) . "\n", FILE_APPEND);
    } else {
        echo 'end';
        break;
    }
}


