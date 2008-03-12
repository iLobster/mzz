<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * captchaViewController: контроллер для метода view модуля captcha
 *
 * @package modules
 * @subpackage captcha
 * @version 0.1.1
 */
class captchaViewController extends simpleController
{
    public function getView()
    {
        $captcha_id = $this->request->getString('rand', SC_GET);

        if ($captcha_id && strlen($captcha_id) == 32) {
            $session = $this->toolkit->getSession();

            $width = 120;
            $height = 40;
            $length = 5;
            $font = dirname(__FILE__) . '/font.ttf';
            $symbols = '1234567890';

            $string = null;
            $im = imagecreatetruecolor($width, $height);

            $background = imagecolorallocate($im, 238, 236, 219);
            $border = imagecolorallocate($im, 0, 0, 0);
            imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $background);

            $pos_x = rand(7, 15);
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

            for ($i = 0; $i < $length; $i++) {
                $char = $symbols[mt_rand(0, strlen($symbols) - 1)];
                $string .= $char;

                $size = mt_rand(18, 25);
                $angle = mt_rand(-15, 15);

                $bbox = imagettfbbox($size, $angle, $font, $char);

                $char_width = max($bbox[2], $bbox[4]) - min($bbox[0], $bbox[6]);
                $char_height = max($bbox[1], $bbox[3]) - min($bbox[7], $bbox[5]);

                $pos_y = (($height + $char_height) / 2);
                //$color_text = imagecolorallocate($im, mt_rand(50, 120), mt_rand(50, 120), mt_rand(50, 120));
                if ($i > 0) {
                    $pos_x -= rand(1, 3);
                }
                imagettftext($im, $size, $angle, $pos_x, $pos_y, $colors[$i], $font, $char);
                $pos_x += $char_width;
            }

            //частоты
            $rand1 = mt_rand(7, 1000) / 150000;
            $rand2 = mt_rand(7000, 100000) / 1500000;
            $rand3 = mt_rand(7000, 100000) / 1500000;
            $rand4 = mt_rand(7000, 100000) / 1500000;
            // фазы
            $rand5 = mt_rand(0, 3141592) / 1000000;
            $rand6 = mt_rand(0, 3141592) / 1000000;
            $rand7 = mt_rand(0, 3141592) / 1000000;
            $rand8 = mt_rand(0, 3141592) / 1000000;
            // амплитуды
            $rand9 = mt_rand(400, 600) / 100;
            $rand10 = mt_rand(400, 600) / 100;

            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $sx = $x + (sin($x * $rand1 + $rand5) + sin($y * $rand3 + $rand6)) * $rand9;
                    $sy = $y + (sin($x * $rand2 + $rand7) + sin($y * $rand4 + $rand8)) * $rand10;

                    if ($sx < 0 || $sy < 0 || $sx >= $width - 1 || $sy >= $height - 1) {
                        $red = 238;
                        $green = 236;
                        $blue = 219;

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
            $image = ob_get_contents();
            ob_end_clean();

            imagedestroy($im);

            $session->set('captcha_' . $captcha_id, md5($string));

            $this->response->setHeader('Content-type', 'image/png');
            return $image;
        }

        $captchaMapper = $this->toolkit->getMapper('captcha', 'captcha');
        return $captchaMapper->get404()->run();
    }
}

?>