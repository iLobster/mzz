<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/forms/validators/formCaptchaRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCaptchaRule.php 1866 2007-07-05 05:07:45Z zerkms $
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

        $captcha_id = $request->get($this->name . '_id', 'string', SC_POST);

        $captcha_sessionkey = 'captcha_' . $captcha_id;

        $captchaValue = $session->get($captcha_sessionkey, false);
        $session->destroy($captcha_sessionkey);

        if ($captchaValue) {
            return (md5($this->value) == $captchaValue);
        }
    }
}

?>