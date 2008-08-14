<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * formCaptionRule: правило каптчи
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formCaptchaRule extends formAbstractRule
{
    public function validate()
    {
        $session = systemToolkit::getInstance()->getSession();
        $request = systemToolkit::getInstance()->getRequest();

        $captcha_id = $request->getString($this->name . '_id', SC_POST | SC_GET);

        $captcha_key = 'mzz_captcha[' . $captcha_id . ']';
        $captchaValue = $session->get($captcha_key, false);

        if ($captchaValue) {
            $session->destroy($captcha_key);
            return (md5($this->value) == $captchaValue);
        }
    }
}

?>