<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1790 2007-06-07 09:48:45Z mz $
 */

/**
 * captchaViewController: контроллер для метода view модуля captcha
 *
 * @package modules
 * @subpackage captcha
 * @version 0.1
 */

class captchaViewController extends simpleController
{
    public function getView()
    {
        $captcha_id = $this->request->get('rand', 'string', SC_GET);

        if ($captcha_id && strlen($captcha_id) == 32) {
            $session = $this->toolkit->getSession();

            $width = 120;
            $height = 60;
            $length = 5;

            $font = dirname(__FILE__) . '/font.ttf';

            $string = null;
            $symbols = '1234567890';

            $im = imagecreatetruecolor($width, $height);

            $background = imagecolorallocate($im, 255, 255, 255);
            $border = imagecolorallocate($im, 0, 0, 0);

            imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $background);

            $pos_x = 5;
            for ($i = 0; $i < $length; $i++) {
                $char = $symbols{mt_rand(0, strlen($symbols) - 1)};
                $string .= $char;

                $size = mt_rand(15, 25);
                $angle = mt_rand(-15, 15);

                $bbox = imagettfbbox($size, $angle, $font, $char);

                $char_width = max($bbox[2], $bbox[4]) - min($bbox[0], $bbox[6]);
                $char_height = max($bbox[1], $bbox[3]) - min($bbox[7], $bbox[5]);

                $pos_y = (($height + $char_height) / 2);
                $color_text = imagecolorallocatealpha($im, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 100));

                imagettftext($im, $size, $angle, $pos_x, $pos_y, $color_text, $font, $char);
                $pos_x += $char_width;
            }

            imagerectangle($im, 0, 0, $width - 1, $height - 1, $border);

            ob_start();
            imagepng($im);
            $image = ob_get_contents();
            ob_end_clean();

            $session->set('captcha_' . $captcha_id, md5($string));

            $this->response->setHeader('Content-type', 'image/png');
            return $image;
        }
    }
}

?>