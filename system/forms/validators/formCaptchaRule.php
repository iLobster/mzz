<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/forms/validators/formCaptchaRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCaptchaRule.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * formCaptiondRule: правило каптчи
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

        $captcha_sessionkey = 'captcha_' . $captcha_id;

        $captchaValue = $session->get($captcha_sessionkey, false);
        $session->destroy($captcha_sessionkey);

        if ($captchaValue) {
            return (md5($this->value) == $captchaValue);
        }
    }
}

?>