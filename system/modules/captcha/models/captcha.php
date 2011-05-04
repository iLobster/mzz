<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/captcha/captcha.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: captcha.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * captcha: класс для работы c данными
 *
 * @package modules
 * @subpackage captcha
 * @version 0.1
 */

class captcha
{
    protected $code;
    protected $image;

    public function getCode()
    {
        return $this->code;
    }

    public function getImage($width, $height, $length, $font)
    {
        if ($this->image) {
            return $this->image;
        }
        $symbols = '123456789';

        $string = null;
        $im = imagecreatetruecolor($width, $height);

        $background = imagecolorallocate($im, 243, 241, 233);
        $border = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 1, 1, $width - 1, $height - 1, $background);

        $colors = array(imagecolorallocate($im, mt_rand(50, 120), mt_rand(50, 120), mt_rand(50, 120)));

        $thick = 2;
        $t = $thick / 2 - 0.5;

        for ($i = 0; $i < $length - 1; $i++) {
            $color = imagecolorallocate($im, mt_rand(60,170), mt_rand(60, 170), mt_rand(60, 170));
            $colors[] = $color;
            $x1 = rand(5, $width);
            $x2 = rand(5, $width - 5);
            $y1 = rand(5, $height);
            $y2 = rand(5, $height - 5);

            if ($x1 == $x2 || $y1 == $y2) {
                imagefilledrectangle($im, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
            } else {
                $k = ($y2 - $y1) / ($x2 - $x1);
                $a = $t / sqrt(1 + pow($k, 2));
                $points = array(
                round($x1 - (1 + $k) * $a), round($y1 + (1 - $k) * $a),
                round($x1 - (1 - $k) * $a), round($y1 - (1 + $k) * $a),
                round($x2 + (1 + $k) * $a), round($y2 - (1 - $k) * $a),
                round($x2 + (1 - $k) * $a), round($y2 + (1 + $k) * $a));
                imagefilledpolygon($im, $points, 4, $color);
                imagepolygon($im, $points, 4, $color);
            }
        }

        $size = ($width / $length) - 4;

        $pos_x = $size / 2   - 2;
        for ($i = 0; $i < $length; $i++) {
            $char = $symbols[mt_rand(0, strlen($symbols) - 1)];
            $string .= $char;

            $char_size = $size;
            $angle = mt_rand(-15, 15);
            $bbox = imagettfbbox($char_size, $angle, $font, $char);

            $char_width = max($bbox[2], $bbox[4]) - min($bbox[0], $bbox[6]);
            $char_height = max($bbox[1], $bbox[3]) - min($bbox[7], $bbox[5]);

            $pos_y = (($height + $char_height) / 2);
            imagettftext($im, $char_size, $angle, $pos_x, $pos_y, $colors[$i], $font, $char);
            $pos_x += $char_width;
        }

        //частоты
        $freqX_1 = mt_rand(7000, 10000) / 1000000;
        $freqY_1 = mt_rand(7000, 100000) / 1000000;
        $freqX_2 = mt_rand(7000, 100000) / 10000000;
        $freqY_2 = mt_rand(7000, 100000) / 10000000;
        // фазы
        $phaseX_1 = mt_rand(0, 314159) / 1000000;
        $phaseX_2 = mt_rand(0, 314159) / 100000;
        $phaseY_1 = mt_rand(0, 314159) / 10000;
        $phaseY_2 = mt_rand(0, 314159) / 1000;
        // амплитуды
        $amplitudesX = mt_rand(300, 400) / 100;
        $amplitudesY = mt_rand(300, 400) / 100;

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $sx = $x + (sin($x * $freqX_1 + $phaseX_1) + sin($y * $freqX_2 + $phaseX_2)) * $amplitudesX;
                $sy = $y + (sin($x * $freqY_1 + $phaseY_1) + sin($y * $freqY_2 + $phaseY_2)) * $amplitudesY;

                if ($sx < 0 || $sy < 0 || $sx >= $width - 1 || $sy >= $height - 1) {
                $red = 243;
                $green = 241;
                $blue = 233;

                $color = $background;
                $color_x = $background;
                $color_y = $background;
                $color_xy = $background;
                } else {
                $color = (imagecolorat($im, $sx, $sy) >> 16) & 0xFF;

                $colorindex = imagecolorat($im, $sx, $sy);
                $red = ($colorindex >> 16) & 0xFF;
                $green = ($colorindex >> 8) & 0xFF;
                $blue = $colorindex & 0xFF;

                $color_x = (imagecolorat($im, $sx + 1, $sy) >> 16) & 0xFF;
                $color_y = (imagecolorat($im, $sx, $sy + 1) >> 16) & 0xFF;
                $color_xy = (imagecolorat($im, $sx + 1, $sy + 1) >> 16) & 0xFF;
                }

                if ($color != $color_x || $color != $color_y || $color != $color_xy) {
                $frsx = $sx - floor($sx); //отклонение координат первообраза от целого
                $frsy = $sy - floor($sy);
                $frsx1 = 1 - $frsx;
                $frsy1 = 1 - $frsy;

                $koef = $color_x  * $frsx  * $frsy1 + $color_y  * $frsx1 * $frsy  + $color_xy * $frsx  * $frsy;

                $red = floor($red * $frsx1 * $frsy1 + $koef);
                $green = floor($green * $frsx1 * $frsy1 + $koef);
                $blue = floor($blue * $frsx1 * $frsy1 + $koef);
                }
                $color = imagecolorallocate($im, $red, $green, $blue);
                imagesetpixel($im, $x, $y, $color);
            }
        }

        imagerectangle($im, 0, 0, $width - 1, $height - 1, $border);

        ob_start();
        imagepng($im);
        $this->image = ob_get_contents();
        ob_end_clean();
        imagedestroy($im);

        $this->code = $string;
        return $this->image;
    }
}

?>