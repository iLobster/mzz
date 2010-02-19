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

fileLoader::load('captcha/models/captcha');

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

            $captcha = new captcha;
            $image = $captcha->getImage(120, 40, 4, dirname(__FILE__) . DIRECTORY_SEPARATOR . 'font.ttf');
            $string = $captcha->getCode();

            $captcha_key = 'mzz_captcha';
            $captchas = $session->get($captcha_key, array());
            if (!is_array($captchas)) {
                $captchas = array();
            }

            $captchas[$captcha_id] = md5($string);
            if (sizeof($captchas) > 5) {
                array_shift($captchas);
            }

            $session->set($captcha_key, $captchas);

            $this->response->setHeader('Content-type', 'image/png');
            return $image;
        }

        return $this->forward404();
    }
}

?>